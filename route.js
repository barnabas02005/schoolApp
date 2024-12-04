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

      document.addEventListener("click", this.handleLinkClick.bind(this));
      window.addEventListener("popstate", this.handlePopState.bind(this));

      this.preloadLinks();
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

      history.pushState({}, "", url);
      this.loadPage(url);
    }

    loadPage(url) {
      const loaderType = this.getLoaderType();

      this.showLoader(loaderType);

      if (this.cache.has(url)) {
        this.renderPage(this.cache.get(url));
        this.hideLoader();
        return;
      }

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

      // Predefined styles for loaders
      this.addLoaderStyles();
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
  
          @keyframes spin {
            to {
              transform: rotate(360deg);
            }
          }
  
          @keyframes slide {
            to {
              background-position: 200% 0;
            }
          }
  
          @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
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
      this.dispatchDOMContentLoaded();

      this.lastLoadedUrl = url;
    }
    dispatchDOMContentLoaded() {
      const event = new Event("DOMContentLoaded", {
        bubbles: true,
        cancelable: true,
      });
      document.dispatchEvent(event);
    }

    extractHeadContent(tempDiv, html) {
      let headContent = tempDiv.querySelector("head");
      if (!headContent) {
        const headMatch = html.match(/<head[^>]*>([\s\S]*?)<\/head>/i);
        return headMatch ? headMatch[1] : "";
      }
      return headContent.innerHTML;
    }

    extractBodyContent(tempDiv, html) {
      let bodyContent = tempDiv.querySelector("body");
      if (!bodyContent) {
        const bodyMatch = html.match(/<body[^>]*>([\s\S]*?)<\/body>/i);
        return bodyMatch ? bodyMatch[1] : html;
      }
      return bodyContent.innerHTML;
    }

    replaceHeadContent(newHead) {
      const tempHead = document.createElement("head");
      tempHead.innerHTML = newHead;
      document.head.innerHTML = ""; // Clear current head
      this.updateElements(document.head, tempHead);
    }

    replaceBodyContent(newBody) {
      const tempBody = document.createElement("body");
      tempBody.innerHTML = newBody;
      document.body.innerHTML = ""; // Clear current body
      this.updateElements(document.body, tempBody);
    }

    updateElements(currentElement, newElement) {
      const currentChildren = Array.from(currentElement.childNodes);
      const newChildren = Array.from(newElement.childNodes);

      for (let i = 0; i < currentChildren.length; i++) {
        const currentChild = currentChildren[i];
        const newChild = newChildren[i];

        if (!currentChild) {
          currentElement.appendChild(newChild.cloneNode(true));
        } else if (!newChild) {
          currentElement.removeChild(currentChild);
        } else if (!currentChild.isEqualNode(newChild)) {
          if (
            currentChild.tagName === "SCRIPT" ||
            currentChild.tagName === "STYLE"
          ) {
            currentElement.replaceChild(newChild.cloneNode(true), currentChild);
          } else if (currentChild.nodeType === Node.ELEMENT_NODE) {
            this.updateAttributes(currentChild, newChild);
            this.updateElements(currentChild, newChild);
          } else {
            currentElement.replaceChild(newChild.cloneNode(true), currentChild);
          }
        }
      }

      for (let i = currentChildren.length; i < newChildren.length; i++) {
        currentElement.appendChild(newChildren[i].cloneNode(true));
      }
    }

    updateAttributes(currentElement, newElement) {
      const currentAttributes = Array.from(currentElement.attributes);
      const newAttributes = Array.from(newElement.attributes);

      currentAttributes.forEach((attr) => {
        if (!newElement.hasAttribute(attr.name)) {
          currentElement.removeAttribute(attr.name);
        }
      });

      newAttributes.forEach((attr) => {
        if (currentElement.getAttribute(attr.name) !== attr.value) {
          currentElement.setAttribute(attr.name, attr.value);
        }
      });
    }

    executeScripts(container) {
      const scripts = container.querySelectorAll("script");
      scripts.forEach((script) => {
        const newScript = document.createElement("script");
        if (script.src) {
          newScript.src = script.src;
        } else {
          newScript.textContent = script.textContent;
        }
        document.body.appendChild(newScript);
        script.remove();
      });
    }

    hashScriptContent(content) {
      let hash = 0;
      for (let i = 0; i < content.length; i++) {
        hash = (hash << 5) - hash + content.charCodeAt(i);
        hash |= 0;
      }
      return hash;
    }

    preloadLinks() {
      const links = document.querySelectorAll("a[href]");

      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            const url = entry.target.href;
            if (!this.cache.has(url)) {
              fetch(url)
                .then((response) => response.ok && response.text())
                .then((html) => html && this.cache.set(url, html));
            }
          }
        });
      });

      links.forEach((link) => observer.observe(link));
    }

    lazyLoadImages() {
      const images = document.querySelectorAll("img[data-src]");

      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            observer.unobserve(img);
          }
        });
      });

      images.forEach((img) => observer.observe(img));
    }

    handlePageLoadError(error) {
      const errorDiv = document.createElement("div");
      errorDiv.textContent = `Failed to load page: ${error.message}`;
      errorDiv.style.color = "red";
      document.body.appendChild(errorDiv);
    }
  }

  if (!window[ROUTER_INSTANCE_KEY]) {
    new CleanPageRouter();
  }
})();
