import './style.scss';

export function how_we_do_it_block() {
  const blockSelector = document.querySelector('.how_we_do_it_block');
  if (!blockSelector) return;
  
  const accordion = blockSelector.querySelector(".accordion");
  

  
  accordion.addEventListener("click", (e) => {
    const activePanel = e.target.closest(".accordion-panel");
    if (!activePanel) return;
    toggleAccordion(activePanel);
  });
  
  function toggleAccordion(panelToActivate, forceOpen = false) {
    const activeButton = panelToActivate.querySelector("button");
    const activePanel = panelToActivate.querySelector(".accordion-content");
    const activePanelIsOpened = activeButton.getAttribute("aria-expanded") === "true";
    
    // Remove active class from all panels
    document.querySelectorAll(".accordion-panel").forEach(panel => {
      panel.classList.remove("active");
      panel.querySelector("button").setAttribute("aria-expanded", false);
      panel.querySelector(".accordion-content").setAttribute("aria-hidden", true);
    });
    
    // Toggle current panel
    if (!activePanelIsOpened || forceOpen) {
      activeButton.setAttribute("aria-expanded", true);
      activePanel.setAttribute("aria-hidden", false);
      panelToActivate.classList.add("active");
    }
  }
  
  
  
    const panels = document.querySelectorAll(".accordion-panel");
    const images = document.querySelectorAll(".right-content-wrapper .image-wrapper");
    
    panels.forEach(panel => {
      panel.addEventListener("click", function () {
        const tabNumber = this.getAttribute("data-tab");
        
        // Remove "active" class from all panels and images
        panels.forEach(p => p.classList.remove("active"));
        images.forEach(img => img.classList.remove("active"));
        
        // Add "active" class to clicked panel
        this.classList.add("active");
        
        // Find corresponding image and add "active" class
        const targetImage = document.querySelector(`.right-content-wrapper .image-wrapper[data-content="${tabNumber}"]`);
        if (targetImage) {
          targetImage.classList.add("active");
        }
      });
    });

  
  
}
