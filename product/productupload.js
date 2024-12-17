const form = document.getElementById('productform');
const productname = document.getElementById('product_name');
const productprice = document.getElementById('product_price');
const productquantity = document.getElementById('product_quantity');
const productdetail = document.getElementById('product_details');
const productimage = document.getElementById('product_image');
const submitButton = document.getElementById('submitbutton');

const pnameerror = document.getElementById('pnameerror');
const prriceerror = document.getElementById('prriceerror');
const quanerror = document.getElementById('quanerror');
const detailserror = document.getElementById('detailserror');

form.addEventListener('submit', (event) => {
    event.preventDefault(); // Prevent default submission
    let isValid = true;

    // Reset all error messages
    pnameerror.textContent = '';
    prriceerror.textContent = '';
    quanerror.textContent = '';
    detailserror.textContent = '';


    // Validate Full Name
    if (productname.value.trim() === '') {
        nameError.textContent = 'Name is required.';
        isValid = false;
    }
    // Validate Class
    if (productprice.value.trim() === '') {
        classError.textContent = 'price is required.';
        isValid = false;
    }

    // Validate Registration Number
    if (productquantity.value.trim() === '') {
        regnumError.textContent = 'Product quantity is required.';
        isValid = false;
    }
     // Validate Registration Number
     if (productdetail.value.trim() === '') {
        regnumError.textContent = 'Product details is required.';
        isValid = false;
    }

    
    // If valid, submit the form
    if (isValid) {
        form.submit();
    }
    
});
