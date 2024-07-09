//Sidenav
const sidenav = document.getElementById("sidenav");
const imgLogo = document.getElementById("img__logo");
const listGroup = document.getElementsByClassName("list-group");

//Header
const header = document.getElementById("header");

//Main
const main = document.getElementById("main");

//Footer
const footer = document.getElementById("footer");

//Buttons
const btnDefaultTheme = document.getElementById("btnDefaultTheme");
const btnChildTheme = document.getElementById("btnChildTheme");
const btnOldTheme = document.getElementById("btnOldTheme");
const btnDark = document.getElementById("btnDark");
const toggleButton = document.getElementById('toggleButton');

//Switches
let isSidenavOpen = false;
let isChildTheme = false;
let isOldTheme = false;

// document.querySelectorAll('.list-group-item').forEach(subitem => {
//     subitem.addEventListener('click', function() {
//         document.querySelector('.active')?.classList.remove('active');
//         subitem.classList.add("active");
//         console.log(subitem)
//         // this.classList.add('active');
//     });
// });

__init();

function __init() {
    isDarkLocalStorage = localStorage.getItem("isDark") === "true";
    changeThemeDarkOrWhite(isDarkLocalStorage);
    
    currentTheme = localStorage.getItem("currentTheme");
    switch(currentTheme) {
        case "default-theme":
            clearThemes();
        break;
        case "child-theme":
            addClassChange("child-theme");
            isChildTheme = true;
        break;
        case "old-theme":
            addClassChange("old-theme");
            isOldTheme = true;
        break;
        default: console.log("Theme not found");
    }
}

toggleButton.addEventListener('click', () => { //Event click drawer sidenav
  if (isSidenavOpen) {
    sidenav.classList.remove('open');
  } else {
    sidenav.classList.add('open');
  }
  isSidenavOpen = !isSidenavOpen;
});


btnDark.addEventListener("click", (e) => { //Event click dark page
    isDarkLocalStorage = localStorage.getItem("isDark") === "true";
    changeThemeDarkOrWhite(!isDarkLocalStorage);
    localStorage.setItem("isDark", !isDarkLocalStorage);
});

btnDefaultTheme.addEventListener("click", () => {
    clearThemes();
    localStorage.setItem("currentTheme", "default-theme");
});

btnChildTheme.addEventListener("click", () => {
    if(!isChildTheme){
        clearThemes();
        addClassChange("child-theme");
        isChildTheme = true;
        localStorage.setItem("currentTheme", "child-theme");
    }
});

btnOldTheme.addEventListener("click", (e) => {
    if(!isOldTheme){
        clearThemes();
        addClassChange("old-theme");
        isOldTheme = true;
        localStorage.setItem("currentTheme", "old-theme");
    }
});

function changeThemeDarkOrWhite(isDark) {
    if(isDark){
        addClassChange("dark");
    }else {
        removeClassChange("dark");
    }
}

function clearThemes() {
    removeClassChange("child-theme");
    removeClassChange("old-theme");
    isChildTheme = false;
    isOldTheme = false;
}

function addClassChange(className) {
    sidenav.classList.add(className);
    imgLogo.classList.add(className);
    header.classList.add(className);
    main.classList.add(className);
    footer.classList.add(className);
    changeThemeListGroup(true, className);
    changeThemeHTag(true, className);
    changeThemeInput(true, className, "input");
    changeThemeInput(true, className, "select");
    changeThemeInput(true, className, "textarea");
    changeThemeElementByClass(true, className, "name__user");
    changeThemeElementByClass(true, className, "dropdown__profile");
    changeThemeElementByClass(true, className, "sidenav__btn__subitem"); //button from sidenav
    changeThemeElementByClass(true, className, "accordion-button"); //accordion from sidenav
    changeThemeElementByClass(true, className, "dropdown__item"); //dropdown
    changeThemeElementByClass(true, className, "page__link"); //pagination
    changeThemeElementByClass(true, className, "btn__primary"); //button
    changeThemeElementByClass(true, className, "table-head"); //table
}

function removeClassChange(className) {
    sidenav.classList.remove(className);
    imgLogo.classList.remove(className);
    header.classList.remove(className);
    main.classList.remove(className);
    footer.classList.remove(className);
    changeThemeListGroup(false, className);
    changeThemeHTag(false, className);
    changeThemeInput(false, className, "input");
    changeThemeInput(false, className, "select");
    changeThemeInput(false, className, "textarea");
    changeThemeElementByClass(false, className, "name__user");
    changeThemeElementByClass(false, className, "dropdown__profile"); 
    changeThemeElementByClass(false, className, "sidenav__btn__subitem"); //button from sidenav
    changeThemeElementByClass(false, className, "accordion-button"); //accordion from sidenav
    changeThemeElementByClass(false, className, "dropdown__item"); //dropdown
    changeThemeElementByClass(false, className, "page__link"); //pagination
    changeThemeElementByClass(false, className, "btn__primary"); //button
    changeThemeElementByClass(false, className, "table-head"); //table
}

function changeThemeHTag(isDark, className){
    const tagsH = ["h1", "h2", "h3", "h4", "h5"];

    for(let i = 0; i < tagsH.length; i++){
        const tags = document.querySelectorAll(tagsH[i]);
        tags.forEach(function(tag){
            if(isDark){
                if(tag) tag.classList.add(className);
            }
            else{
                if(tag) tag.classList.remove(className);
            }
        })
    }
}

function changeThemeInput(isDark, className, type) {
    const inputs = document.querySelectorAll(type);
    
    inputs.forEach(function(input) {
        if(isDark){
            input.classList.add(className);
        }else{
            input.classList.remove(className);
        }
    });
}

function changeThemeElementByClass(isDark, className, typeElement){
    const elements = document.getElementsByClassName(typeElement);
    for(let i = 0; i < elements.length; i++){
        if(isDark){
            elements[i].classList.add(className)
        }else{
            elements[i].classList.remove(className)
        }
    }
}

function changeThemeListGroup(isDark, className) {  //Change theme buttons list-group
    if(listGroup == undefined) return;
    for(let i = 0; i < listGroup.length; i++ ) {
        if(isDark)
            listGroup[i].classList.add(className);
        else
            listGroup[i].classList.remove(className);
    }
}