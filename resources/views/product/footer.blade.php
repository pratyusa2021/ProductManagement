</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    //group add limit
    var maxGroup = 10;
    
    //add more fields group
    $(".addMore").click(function(){
        if($('body').find('.add_image').length < maxGroup){
            var fieldHTML = '<li class="add_image">'+$(".add_image_copy").html()+'</li>';
            $('body').find('.add_image:last').after(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' groups are allowed.');
        }
    });
    
    //remove fields group
    $("body").on("click",".remove",function(){ 
        $(this).parents(".add_image").remove();
    });

    $.noConflict();
    
    const table = $('#products').DataTable({
        ajax: '',
        serverSide: true,
        processing: true,
        columns: [
            {data: 'product_name', name: 'product_name'},
            {data: 'product_price', name: 'product_price'},
            {data: 'product_description', name: 'product_description'},
            {data: 'action', name: 'action'},
        ]
    });


    $(".reload" ).click(function() {
        table.ajax.reload(null, false);
    }); 

    $(document).on('submit', '#addProductForm', function(event){
        event.preventDefault();
        const productName = document.querySelector('#name');
        const productPrice = document.querySelector('#price');
        const productDescription = document.querySelector('#description');

        const checkProductname = () => {
            let valid = false;
            const min = 3,
                max = 100;
            const name = productName.value.trim();

            if (!isRequired(name)) {
                document.getElementById('ProductNameAddError').style.display = "block";
                document.getElementById('ProductNameAddError').innerText = "Product Name is required";
            } else if (!isBetween(name.length, min, max)) {
                document.getElementById('ProductNameAddError').style.display = "block";
                document.getElementById('ProductNameAddError').innerText = "Product Name is must have atleast 3 letter and max 100";
            } else {
                valid = true;
            }
            return valid;
        };

        const checkPrice = () => {
            let valid = false;

            const price = productPrice.value.trim();

            if (!isRequired(price)) {
                document.getElementById('ProductPriceAddError').style.display = "block";
                document.getElementById('ProductPriceAddError').innerText = "Product Price is required";
            } else {
                valid = true;
            }
            return valid;
        };

        const checkDescription = () => {
            let valid = false;
            const min = 3,
                max = 250;
            const description = productDescription.value.trim();

            if (!isRequired(description)) {
                document.getElementById('ProductDescriptionAddError').style.display = "block";
                document.getElementById('ProductDescriptionAddError').innerText = "Product description is required";
            } else if (!isBetween(description.length, min, max)) {
                document.getElementById('ProductDescriptionAddError').style.display = "block";
                document.getElementById('ProductDescriptionAddError').innerText = "Product description is must have atleast 3 letter and max 100";
            } else {
                valid = true;
            }
            return valid;
        };

        const isRequired = value => value === '' ? false : true;
        const isBetween = (length, min, max) => length < min || length > max ? false : true;

        let isValidName = checkProductname(),
        isValidPrice = checkPrice(),
        isValidDescription = checkDescription();

        let isFormValid = isValidName &&
        isValidPrice &&
        isValidDescription;

        if (isFormValid) {
            var formData = new FormData(this);
            $.ajax({
                type:'POST',
                url: "{{ action('ProductController@store')}}",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: (data) => {
                        this.reset();
                        table.ajax.reload(null, false);
                        alert('File has been uploaded successfully');
                },
                error: function(data){
                    alert('Error!!');
                }
            });

        }else{
            alert('All fields except Image is required');
        }
        table.ajax.reload(null, false);

    });

    $(document).on('submit', '#editProductForm', function(event){
        event.preventDefault();
        const productName = document.querySelector('#product_name');
        const productPrice = document.querySelector('#product_price');
        const productDescription = document.querySelector('#product_description');

        const checkProductname = () => {
            let valid = false;
            const min = 3,
                max = 100;
            const name = productName.value.trim();

            if (!isRequired(name)) {
                document.getElementById('ProductNameEditError').style.display = "block";
                document.getElementById('ProductNameEditError').innerText = "Product Name is required";
            } else if (!isBetween(name.length, min, max)) {
                document.getElementById('ProductNameEditError').style.display = "block";
                document.getElementById('ProductNameEditError').innerText = "Product Name is must have atleast 3 letter and max 100";
            } else {
                valid = true;
            }
            return valid;
        };

        const checkPrice = () => {
            let valid = false;

            const price = productPrice.value.trim();

            if (!isRequired(price)) {
                document.getElementById('ProductPriceEditError').style.display = "block";
                document.getElementById('ProductPriceEditError').innerText = "Product Price is required";
            } else {
                valid = true;
            }
            return valid;
        };

        const checkDescription = () => {
            let valid = false;
            const min = 3,
                max = 250;
            const description = productDescription.value.trim();

            if (!isRequired(description)) {
                document.getElementById('ProductDescriptionEditError').style.display = "block";
                document.getElementById('ProductDescriptionEditError').innerText = "Product description is required";
            } else if (!isBetween(description.length, min, max)) {
                document.getElementById('ProductDescriptionEditError').style.display = "block";
                document.getElementById('ProductDescriptionEditError').innerText = "Product description is must have atleast 3 letter and max 100";
            } else {
                valid = true;
            }
            return valid;
        };

        const isRequired = value => value === '' ? false : true;
        const isBetween = (length, min, max) => length < min || length > max ? false : true;

        let isValidName = checkProductname(),
        isValidPrice = checkPrice(),
        isValidDescription = checkDescription();

        let isFormValid = isValidName &&
        isValidPrice &&
        isValidDescription;

        if (isFormValid) {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                url: "{{ action('ProductController@update')}}",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: (data) => {
                        window.location = location.href;
                        alert('File has been uploaded successfully');
                },
                error: function(data){
                    alert('Error');
                }
            });

        }else{
            alert('All fields except Image is required');
        }
        dataTableReload();

    });
})

function dataTableReload(){
    $('#products').DataTable().destroy();
    const table = $('#products').DataTable({
        ajax: '',
        serverSide: true,
        processing: true,
        columns: [
            {data: 'product_name', name: 'product_name'},
            {data: 'product_price', name: 'product_price'},
            {data: 'product_description', name: 'product_description'},
            {data: 'action', name: 'action'},
        ]
    });
    table.ajax.reload(null, false);
}

function deleteProduct(id){
    var url = '/'+id+'/delete';
    $.ajax({
      type: 'get',
      url: url,
      success: (data) => {
        alert('Product Deleted Successfully');
      }
    });
    dataTableReload();
}

function deleteImage(id){
    var url = '/'+id+'/delete-image';
    $.ajax({
      type: 'get',
      url: url,
      success: (data) => {
        window.location = location.href;
        alert('Image Deleted Successfully');
      }
    });
}
</script>