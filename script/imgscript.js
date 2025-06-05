// Fonction pour récupérer toutes les images du slider
function getSliderImages(sliderId) {
  return document.querySelectorAll(`#${sliderId} img`);
}

function autoSlide(sliderId, prevButtonId, nextButtonId) {
  const sliderElement = document.getElementById(sliderId);
  const images = getSliderImages(sliderId);
  const prevButton = document.getElementById(prevButtonId);
  const nextButton = document.getElementById(nextButtonId);
  
  let index = 0;
  const imageWidth = 100; // Pourcentage (100% par image)

  function showSlide(newIndex) {
    // Gestion des limites
    if (newIndex < 0) {
      index = images.length - 1;
    } else if (newIndex >= images.length) {
      index = 0;
    } else {
      index = newIndex;
    }   
    sliderElement.style.transform = `translateX(-${index * imageWidth}%)`;
  }

  // Événements
  prevButton.addEventListener('click', () => showSlide(index - 1));
  nextButton.addEventListener('click', () => showSlide(index + 1));
}

// Utilisation
autoSlide('slider-images1', 'carre1', 'carre2');
autoSlide('slider-images2', 'carre3', 'carre4');
autoSlide('slider-images3', 'carre5', 'carre6');