let userBox = document.querySelector('.header .header-2 .user-box');

document.querySelector('#user-btn').onclick = () =>{
   userBox.classList.toggle('active');
   navbar.classList.remove('active');
}

let navbar = document.querySelector('.header .header-2 .navbar');

document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   userBox.classList.remove('active');
}

window.onscroll = () =>{
   userBox.classList.remove('active');
   navbar.classList.remove('active');

   if(window.scrollY > 60){
      document.querySelector('.header .header-2').classList.add('active');
   }else{
      document.querySelector('.header .header-2').classList.remove('active');
   }
}

// Get elements
const contactBtns = document.querySelectorAll('.contact-seller-btn'); 
const popup = document.getElementById('contact-popup');
const closeBtn = document.querySelector('.close-btn'); 
const productNameDisplay = document.getElementById('product-name');
const productNameInput = document.getElementById('product-name-input');
const sellerIdInput = document.getElementById('seller-id-input');

// Open Pop-up
contactBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    const productName = btn.dataset.productName; 
    const sellerId = btn.dataset.sellerId;

    productNameDisplay.textContent = productName;
    productNameInput.value = productName; 
    sellerIdInput.value = sellerId;

    popup.style.display = 'flex'; 
  });
});

// Close Pop-up (no changes needed here)
closeBtn.addEventListener('click', () => {
    popup.style.display = 'none';
});
