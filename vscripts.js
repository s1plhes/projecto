
const Swal = require('sweetalert2')

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
	'use strict'
  
	// Fetch all the forms we want to apply custom Bootstrap validation styles to
	var forms = document.querySelectorAll('.needs-validation')
  
	// Loop over them and prevent submission
	Array.prototype.slice.call(forms)
	  .forEach(function (form) {
		form.addEventListener('submit', function (event) {
		  if (!form.checkValidity()) {
			event.preventDefault()
			event.stopPropagation()
		  }
  
		  form.classList.add('was-validated')
		}, false)
	  })
  })()
  

function rph()
  	{
		const NodeList = document.querySelectorAll('.placeholder');
			for (let i = 0; i < NodeList.length; i++){
				NodeList[i].classList.remove('placeholder');
				console.log("removed -" + NodeList[i] + "placeholder");
			};
		const NodeList2 = document.querySelectorAll('.placeholder-glow');
			for (let i = 0; i < NodeList.length; i++){
				NodeList2[i].classList.remove('placeholder-glow');
				console.log("removed -" + NodeList2[i] + "placeholder-glow");
			};
	 };


	 Swal.fire({
		title: 'Error!',
		text: 'Do you want to continue',
		icon: 'error',
		confirmButtonText: 'Cool'
	  });


