function generateRandomColor(bgcolor = 'white') {
  // Helper function to calculate relative luminance
  const getLuminance = (r, g, b) => {
    let [rs, gs, bs] = [r/255, g/255, b/255].map(c => {
      return c <= 0.03928 ? c/12.92 : Math.pow((c + 0.055)/1.055, 2.4);
    });
    return 0.2126 * rs + 0.7152 * gs + 0.0722 * bs;
  };

  // Helper function to calculate contrast ratio
  const getContrastRatio = (l1, l2) => {
    const lighter = Math.max(l1, l2);
    const darker = Math.min(l1, l2);
    return (lighter + 0.05) / (darker + 0.05);
  };

  // Background luminance
  const bgLuminance = bgcolor.toLowerCase() === 'white' ? 1 : 0;
  
  // Minimum contrast ratio we want to achieve
  const MIN_CONTRAST = 4.5;
  
  let attempts = 0;
  let maxAttempts = 100;
  
  while (attempts < maxAttempts) {
    // Generate random RGB values
    const r = Math.floor(Math.random() * 256);
    const g = Math.floor(Math.random() * 256);
    const b = Math.floor(Math.random() * 256);
    
    // Calculate luminance and contrast
    const colorLuminance = getLuminance(r, g, b);
    const contrastRatio = getContrastRatio(colorLuminance, bgLuminance);
    
    // Check if contrast is sufficient
    if (contrastRatio >= MIN_CONTRAST) {
      // Convert to hex
      const toHex = (n) => {
        const hex = n.toString(16);
        return hex.length === 1 ? '0' + hex : hex;
      };
      
      return '#' + toHex(r) + toHex(g) + toHex(b);
    }
    
    attempts++;
  }
  
  // Fallback colors if we couldn't generate one with sufficient contrast
  return bgcolor.toLowerCase() === 'white' ? '#000000' : '#FFFFFF';
}