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

const viewSellerBtns = document.querySelectorAll('.contact-seller-btn'); 
const sellerInfoPopup = document.getElementById('seller-info-popup');
const sellerDetailsContainer = document.getElementById('seller-details');
const closeBtn = document.querySelector('.seller-close-btn'); 

viewSellerBtns.forEach(btn => {
    btn.addEventListener('click', (event) => {
        event.preventDefault(); // Prevent default form submission

        const sellerId = btn.dataset.sellerId;

        // Make an AJAX request to fetch seller details
        fetch('fetch_seller_details.php?seller_id=' + sellerId) // Add this php file in your directory.
            .then(response => response.json())
            .then(data => {
                // Populate sellerDetailsContainer with the fetched data
                sellerDetailsContainer.innerHTML = `
                    <h3>${data.name}'s Bookshop</h3>
                    <p>Email: ${data.email}</p>
                    <p>Verified: ${data.verified == 1 ? 'Yes' : 'No'}</p>
                    </div>`; // Updated content structure

                sellerInfoPopup.style.display = 'flex';
            })
            .catch(error => console.error('Error fetching seller details:', error));
    });
});

// Close Pop-up (no changes needed here)
closeBtn.addEventListener('click', () => {
    sellerInfoPopup.style.display = 'none';
});

const isbnInput = document.getElementById('isbn');
const coverPreview = document.getElementById('cover-preview');

isbnInput.addEventListener('input', function() {
  const isbn = this.value.trim();

  if (isbn) {
    fetch(`https://openlibrary.org/api/books?bibkeys=ISBN:${isbn}&format=json&jscmd=data`)
      .then(response => response.json())
      .then(data => {
        const bookData = data[`ISBN:${isbn}`];
        if (bookData && bookData.cover) {
          coverPreview.innerHTML = `<img src="${bookData.cover.medium}" alt="Book Cover" style="max-width: 150px;">`; // Display the cover
        } else {
          coverPreview.innerHTML = ''; // Clear the preview if no cover found
        }
      })
      .catch(error => {
        console.error('Error fetching cover image:', error);
        coverPreview.innerHTML = ''; // Clear the preview if error
      });
  } else {
    coverPreview.innerHTML = ''; // Clear the preview if ISBN is empty
  }
});


/* not sure it sure if its included confirmaion from milton is need

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

*/