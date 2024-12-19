(function () {
  const ROUTER_INSTANCE_KEY = "__CLEAN_PAGE_ROUTER_INSTANCE__";

  class CleanPageRouter {
    constructor() {
      if (window[ROUTER_INSTANCE_KEY]) {
        return window[ROUTER_INSTANCE_KEY];
      }

      window[ROUTER_INSTANCE_KEY] = this;

      if (this.initialized) return this;
      this.initialized = true;

      this.cache = new Map();
      this.executedInlineScripts = new Set();

      this.resetConsoleLogging();
      this.init();
    }

    resetConsoleLogging() {
      const originalLog = console.log;
      const loggedMessages = new Set();

      console.log = (...args) => {
        const messageKey = args.map((arg) => String(arg)).join("|");
        if (!loggedMessages.has(messageKey)) {
          originalLog(...args);
          loggedMessages.add(messageKey);
        }
      };
    }

    init() {
      this.removeExistingListeners();
      this.addLoaderStyles();
      document.addEventListener("click", this.handleLinkClick.bind(this));
      window.addEventListener("popstate", this.handlePopState.bind(this));

      this.preloadLinks();
      this.prefetchNextPage(); // Add prefetching of the next pages
      this.loadCriticalCSS();
      this.lazyLoadImages();
    }

    removeExistingListeners() {
      const events = ["click", "popstate"];
      events.forEach((eventName) => {
        document.removeEventListener(eventName, this.handleLinkClick);
        window.removeEventListener(eventName, this.handlePopState);
      });
    }

    handleLinkClick(e) {
      const link = e.target.closest("a");
      if (link && link.hostname === window.location.hostname) {
        e.preventDefault();
        this.navigateTo(link.href);
      }
    }

    handlePopState() {
      this.loadPage(window.location.href);
    }

    navigateTo(url) {
      if (this.lastLoadedUrl === url) return;

      // Save the current scroll position to sessionStorage
      sessionStorage.setItem("scrollPosition", window.scrollY);

      console.log(window.scrollY);

      history.pushState({}, "", url);
      this.loadPage(url);
    }

    loadPage(url) {
      const loaderType = this.getLoaderType();

      this.showLoader(loaderType);

      if (this.cache.has(url)) {
        // Check if cached version should be used or a fresh fetch is needed
        if (this.isCacheStale(url)) {
          this.fetchAndRenderPage(url);
        } else {
          this.renderPage(this.cache.get(url));
          this.hideLoader();

          // Restore scroll position after page is rendered
          this.restoreScrollPosition();
        }
        return;
      }

      this.fetchAndRenderPage(url);
    }

    isCacheStale(url) {
      // Check if the cached HTML content size is significantly smaller than the live version
      const cacheContent = this.cache.get(url);
      if (cacheContent) {
        return fetch(url, { method: "HEAD" }).then((response) => {
          const liveSize = parseInt(response.headers.get("Content-Length"), 10);
          const cacheSize = cacheContent.length;
          return liveSize > cacheSize * 1.2; // Example threshold for cache staleness
        });
      }
      return true;
    }

    fetchAndRenderPage(url) {
      fetch(url)
        .then((response) => {
          if (!response.ok)
            throw new Error(`HTTP error! status: ${response.status}`);
          return response.text();
        })
        .then((html) => {
          this.cache.set(url, html);
          this.renderPage(html, url);
          this.hideLoader();
        })
        .catch((error) => {
          console.error("Page load error:", error);
          this.hideLoader();
          this.handlePageLoadError(error);
        });
    }

    getLoaderType() {
      const metaLoader = document.querySelector('meta[name="loader-type"]');
      return metaLoader ? metaLoader.content : null;
    }

    showLoader(type) {
      if (!type) return;

      const loaderContainer = document.createElement("div");
      loaderContainer.id = "loader-container";
      loaderContainer.className = `loader-${type}`;
      document.body.appendChild(loaderContainer);
    }

    hideLoader() {
      const loaderContainer = document.getElementById("loader-container");
      if (loaderContainer) {
        loaderContainer.remove();
      }
    }

    addLoaderStyles() {
      if (document.getElementById("loader-styles")) return;

      const style = document.createElement("style");
      style.id = "loader-styles";
      style.textContent = `
        #loader-container {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          display: flex;
          justify-content: center;
          align-items: center;
          background: rgba(255, 255, 255, 0.8);
          z-index: 9999;
        }
        .loader-spinner {
          border: 8px solid rgba(0, 0, 0, 0.1);
          border-top: 8px solid #3498db;
          border-radius: 50%;
          width: 60px;
          height: 60px;
          animation: spin 1s linear infinite;
        }
        .loader-linear {
          width: 100%;
          height: 4px;
          background: linear-gradient(90deg, #3498db, #8e44ad, #e74c3c);
          background-size: 200% 100%;
          animation: slide 1.5s linear infinite;
        }
        .loader-gradient {
          width: 60px;
          height: 60px;
          border-radius: 50%;
          background: linear-gradient(45deg, #3498db, #8e44ad, #e74c3c);
          background-size: 400% 400%;
          animation: gradientShift 2s infinite;
        }

        #skeleton-loader {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          display: flex;
          justify-content: center;
          align-items: center;
          background: rgba(255, 255, 255, 0.8);
          z-index: 9999;
        }
        .skeleton-wrapper {
          width: 80%;
          max-width: 600px;
          text-align: center;
        }
        .skeleton-item {
          margin: 10px 0;
          background-color: #ccc;
          border-radius: 4px;
        }
        .skeleton-text {
          height: 20px;
          width: 100%;
        }
        .skeleton-image {
          height: 200px;
          width: 100%;
          max-width: 300px;
          margin: auto;
        }
        @keyframes spin {
          to { transform: rotate(360deg); }
        }
        @keyframes slide {
          to { background-position: 200% 0; }
        }
        @keyframes gradientShift {
          0% { background-position: 0% 50%; }
          50% { background-position: 100% 50%; }
          100% { background-position: 0% 50%; }
        }
      `;
      document.head.appendChild(style);
    }

    addSkeletonLoaderStyles() {
      if (document.getElementById("skeleton-loader-styles")) return;

      const style = document.createElement("style");
      style.id = "skeleton-loader-styles";
      style.textContent = `
        #skeleton-loader {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          display: flex;
          justify-content: center;
          align-items: center;
          background: rgba(255, 255, 255, 0.8);
          z-index: 9999;
        }
        .skeleton-wrapper {
          width: 80%;
          max-width: 600px;
          text-align: center;
        }
        .skeleton-item {
          margin: 10px 0;
          background-color: #ccc;
          border-radius: 4px;
        }
        .skeleton-text {
          height: 20px;
          width: 100%;
        }
        .skeleton-image {
          height: 200px;
          width: 100%;
          max-width: 300px;
          margin: auto;
        }
      `;
      document.head.appendChild(style);
    }

    renderPage(html, url) {
      const tempDiv = document.createElement("div");
      tempDiv.innerHTML = html;

      const newHead = this.extractHeadContent(tempDiv, html);
      const newBody = this.extractBodyContent(tempDiv, html);

      this.replaceHeadContent(newHead);
      this.replaceBodyContent(newBody);
      this.executeScripts(tempDiv);

      // Dispatch DOMContentLoaded event after rendering
      // Dispatch a custom event after page is rendered
      this.dispatchDOMContentLoaded();

      this.lastLoadedUrl = url;
    }

    dispatchDOMContentLoaded() {
      const event = new Event("DOMContentLoaded", {
        bubbles: true,
        cancelable: true,
      });
      document.dispatchEvent(event);
      window.dispatchEvent(event);
    }

    extractHeadContent(tempDiv, html) {
      const headMatch = html.match(/<head([^>]*)>([\s\S]*?)<\/head>/i);
      if (headMatch) {
        return {
          attributes: headMatch[1].trim(),
          content: headMatch[2],
        };
      }
      return null;
    }

    extractBodyContent(tempDiv, html) {
      const bodyMatch = html.match(/<body([^>]*)>([\s\S]*?)<\/body>/i);
      if (bodyMatch) {
        return {
          attributes: bodyMatch[1].trim(),
          content: bodyMatch[2],
        };
      }
      return null;
    }

    replaceHeadContent(newHead) {
      if (!newHead) return;

      const oldHead = document.querySelector("head");
      if (oldHead) {
        oldHead.innerHTML = newHead.content;
      }
    }

    replaceBodyContent(newBody) {
      if (!newBody) return;

      const oldBody = document.querySelector("body");
      const fragment = document.createDocumentFragment();
      const newBodyEl = document.createElement("div");
      newBodyEl.innerHTML = newBody.content;

      // Append all child nodes of newBodyEl directly to the oldBody
      while (newBodyEl.firstChild) {
        fragment.appendChild(newBodyEl.firstChild);
      }

      oldBody.innerHTML = ""; // Clear existing content
      oldBody.appendChild(fragment); // Append the new content
    }

    executeScripts(tempDiv) {
      const scripts = tempDiv.querySelectorAll("script");
      scripts.forEach((script) => {
        if (script.src && !this.executedInlineScripts.has(script.src)) {
          const scriptEl = document.createElement("script");
          scriptEl.src = script.src;
          scriptEl.onload = () => this.executedInlineScripts.add(script.src);
          document.body.appendChild(scriptEl);
        } else if (
          !script.src &&
          !this.executedInlineScripts.has(script.textContent)
        ) {
          const inlineScript = document.createElement("script");
          inlineScript.textContent = script.textContent;
          document.body.appendChild(inlineScript);
          this.executedInlineScripts.add(script.textContent);
        }
      });
    }

    restoreScrollPosition() {
      const scrollPosition = sessionStorage.getItem("scrollPosition");
      if (scrollPosition !== null) {
        window.scrollTo(0, parseInt(scrollPosition, 10));
        sessionStorage.removeItem("scrollPosition"); // Clear stored scroll position after restoring it
      }
    }

    preloadLinks() {
      const links = document.querySelectorAll("a");
      links.forEach((link) => {
        link.addEventListener("mouseover", this.preloadPage.bind(this));
      });
    }

    preloadPage(e) {
      const link = e.target.closest("a");
      if (link) {
        fetch(link.href).then(() => {
          console.log(`Preloaded ${link.href}`);
        });
      }
    }

    prefetchNextPage() {
      const nextPage = document.querySelector("link[rel='prefetch']");
      if (nextPage) {
        const nextUrl = nextPage.href;
        this.preloadPage({ target: { href: nextUrl } });
      }
    }

    lazyLoadImages() {
      const images = document.querySelectorAll("img[data-src]");
      images.forEach((img) => {
        img.src = img.getAttribute("data-src");
        img.removeAttribute("data-src");
      });
    }

    loadCriticalCSS() {
      const link = document.querySelector(
        "link[rel='stylesheet'][media='print']"
      );
      if (link) {
        link.onload = () => {
          link.media = "all";
        };
      }
    }

    handlePageLoadError(error) {
      // Custom error handler to show a message or redirect to a fallback page
      console.error("An error occurred while loading the page:", error);
      document.body.innerHTML = `<p>Failed to load the page. Please try again later.</p>`;
    }
  }

  if (!window[ROUTER_INSTANCE_KEY]) {
    new CleanPageRouter();
  }
})();
