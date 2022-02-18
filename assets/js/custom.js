// var tooltipEl = document.getElementById('header-tooltip');
// var tootltip = new coreui.Tooltip(tooltipEl);


$(".minimize-card").on('click', function() {
    var $this = $(this);
    var port = $($this.parents('.card'));
    var card = $(port).children('.card-body').slideToggle();
    var card = $(port).children('.c-card-body').slideToggle();
    $(this).toggleClass("cil-arrow-circle-bottom").fadeIn('slow');
    $(this).toggleClass("cil-arrow-circle-top").fadeIn('slow');
});

$('.custom-file-input').on('change',function(){
    //get the file name
    var fileName = $(this).val().split("\\").pop(); 		
    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName);
});

// check for saved 'darkMode' in localStorage
// let darkMode = localStorage.getItem('darkMode'); 

// const darkModeToggle = document.querySelector('#headertooltip');

// const enableDarkMode = () => {
// // 1. Add the class to the body
// document.body.classList.add('c-dark-theme');
// // 2. Update darkMode in localStorage
// localStorage.setItem('darkMode', 'enabled');
// }

// const disableDarkMode = () => {
// // 1. Remove the class from the body
// document.body.classList.remove('c-dark-theme');
// // 2. Update darkMode in localStorage 
// localStorage.setItem('darkMode', null);
// }

// // If the user already visited and enabled darkMode
// // start things off with it on
// if (darkMode === 'enabled') {
// enableDarkMode();
// }

// // When someone clicks the button
// darkModeToggle.addEventListener('click', () => {
// // get their darkMode setting
// darkMode = localStorage.getItem('darkMode'); 

// if it not current enabled, enable it
// if (darkMode !== 'enabled') {
//     enableDarkMode();
// // if it has been enabled, turn it off  
// } else {  
//     disableDarkMode(); 
// }
// });