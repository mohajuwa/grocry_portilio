// Function to fetch language data
async function fetchLanguageData(lang) {
  const response = await fetch(`languages/${lang}.json`);
  return response.json();
}

// Function to set the language preference
function setLanguagePreference(lang) {
  localStorage.setItem('language', lang);
  location.reload();
}

// Function to update content based on selected language
function updateContent(langData) {
  document.querySelectorAll('[data-i18n]').forEach(element => {
    const key = element.getAttribute('data-i18n');
    const elementType = element.tagName.toLowerCase();

    if (elementType === 'span') {
      // For span elements, update innerText
      element.innerText = langData[key];
    } else {
      // For other elements, update textContent
      element.textContent = langData[key];
    }
  });
}


// Function to update brand text based on selected language
function updateBrandText(langData) {
  const brandNameElement = document.querySelector('[data-i18n="brandName"]');
  const brandSubNameElement = document.querySelector('[data-i18n="brandSubName"]');

  if (brandNameElement && brandSubNameElement) {
    brandNameElement.textContent = langData.brandName || '';
    brandSubNameElement.textContent = langData.brandSubName || '';
  }
}

// Function to change language
async function changeLanguage(lang) {
  await setLanguagePreference(lang);

  const langData = await fetchLanguageData(lang);
  updateContent(langData);
  updateBrandText(langData);
  toggleArabicStylesheet(lang); // Toggle Arabic stylesheet
}

// Function to toggle Arabic stylesheet based on language selection
function toggleArabicStylesheet(lang) {
  const head = document.querySelector('head');
  const link = document.querySelector('#styles-link');

  if (link) {
    head.removeChild(link); // Remove the old stylesheet link
  } else if (lang === 'ar') {
    const newLink = document.createElement('link');
    newLink.id = 'styles-link';
    newLink.rel = 'stylesheet';
    newLink.href = 'css/style-ar.css'; // Path to Arabic stylesheet
    head.appendChild(newLink);
  }
}

// Function to update language flag image
function updateLanguageFlagImage(lang) {
  const flagImage = document.querySelector('.language-flag');
  if (flagImage) {
    const imagePath = getLanguageImagePath(lang);
    flagImage.src = imagePath;
  }
}

// Example mapping of language codes to image paths
function getLanguageImagePath(lang) {
  const imagePaths = {
    'en': 'img/us.png',
    'ar': 'img/sa.png',
    // Add more language codes and paths as needed
  };

  return imagePaths[lang] || '';
}

// Call updateContent() on page load
window.addEventListener('DOMContentLoaded', async () => {
  const userPreferredLanguage = localStorage.getItem('language') || 'ar';
  const langData = await fetchLanguageData(userPreferredLanguage);
  updateContent(langData);
  updateBrandText(langData);
  toggleArabicStylesheet(userPreferredLanguage);
  updateLanguageFlagImage(userPreferredLanguage);

  // Set the selected language in the dropdown
  const selectedLanguage = readCookie('language');

  if (selectedLanguage) {
    $("#languageDropdown a").removeClass("active"); // Remove the active class from all items
    $(`#languageDropdown a[value="${selectedLanguage}"]`).addClass("active"); // Add the active class to the selected item
  }
  if (selectedLanguage == null) {
    selectedLanguage === 'ar';
    $(".en").css("display", "none");
    $(".ar").css("display", "inline");

  }
  else if ((selectedLanguage == 'en') || (selectedLanguage == 'ar')) {
    $(".language select").val(selectedLanguage);
    var sel = $(".language select").val(selectedLanguage);
    if (selectedLanguage == 'en') {
      $(".en").css("display", "inline");
      $(".ar").css("display", "none");

    } else if (selectedLanguage == 'ar') {
      $(".en").css("display", "none");
      $(".ar").css("display", "inline");


    }
  }
  console.log(selectedLanguage);
  // Handle language selection in the dropdown
  $("#languageDropdown a").on("click", function (event) {
    event.preventDefault();
    const selectedLanguage = $(this).attr("value");
    changeLanguage(selectedLanguage);
    saveLanguage(selectedLanguage);

    // Highlight the selected language in the dropdown
    $("#languageDropdown a").removeClass("active");
    $(this).addClass("active");
  });
  function saveLanguage(cookieValue) {
    setCookie('language', cookieValue, 365);
  }

  function setCookie(cookieName, cookieValue, nDays) {
    var today = new Date();
    var expire = new Date();

    if (nDays == null || nDays == 0)
      nDays = 1;

    expire.setTime(today.getTime() + 3600000 * 24 * nDays);
    document.cookie = cookieName + "=" + escape(cookieValue) + ";expires=" + expire.toGMTString();
  }

  function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') c = c.substring(1, c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
  }

});

