// scripts.js
document.getElementById('registerForm').addEventListener('submit', function() {
    var submitBtn = document.getElementById('submitBtn');
    var loader = document.getElementById('loader');
    
    submitBtn.style.display = 'none';
    loader.style.display = 'block';
});
