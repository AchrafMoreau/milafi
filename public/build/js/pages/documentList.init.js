
FilePond.registerPlugin(
    // encodes the file as base64 data
    FilePondPluginFileEncode,
    // validates the size of the file
    FilePondPluginFileValidateSize,
    // corrects mobile image orientation
    FilePondPluginImageExifOrientation,
    // previews dropped images
    FilePondPluginImagePreview
);

var inputMultipleElements = document.querySelectorAll('input.filepond-input-multiple');
if(inputMultipleElements){

// loop over input elements
var pondInstances = [];

Array.from(inputMultipleElements).forEach(function (inputElement) {
    // create a FilePond instance at the input element location
    let pondInstance = FilePond.create(inputElement);
    pondInstances.push(pondInstance); // Store instance in an array

})

var fileInput = FilePond.create(
    document.querySelector('.filepond-input-circle'), {
        labelIdle: 'Drag & Drop your picture or <span class="filepond--label-action">Browse</span>',
        imagePreviewHeight: 170,
        imageCropAspectRatio: '1:1',
        imageResizeTargetWidth: 200,
        imageResizeTargetHeight: 200,
        stylePanelLayout: 'compact circle',
        styleLoadIndicatorPosition: 'center bottom',
        styleProgressIndicatorPosition: 'right bottom',
        styleButtonRemoveItemPosition: 'left bottom',
        styleButtonProcessItemPosition: 'right bottom',
        allowFileEncode: false, // Ensure this is disabled if using file encoding
    }
)

const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
FilePond.setOptions({
    server: {
        method: 'POST',
        process:{
            url: '/upload',
            headers:{
                'X-CSRF-TOKEN' : '{{ csrf_token() }}',
                'X-CSRF-TOKEN' : token
            }
        }
    },
});
}

var checkAll = document.getElementById("checkAll");
if (checkAll) {
    checkAll.onclick = function () {
        var checkboxes = document.querySelectorAll('.form-check-all input[type="checkbox"]');
        if (checkAll.checked == true) {
            Array.from(checkboxes).forEach(function (checkbox) {
                checkbox.checked = true;
                checkbox.closest("tr").classList.add("table-active");
            });
        } else {
            Array.from(checkboxes).forEach(function (checkbox) {
                checkbox.checked = false;
                checkbox.closest("tr").classList.remove("table-active");
            });
        }
    };
}

var perPage = 10;
var editlist = false;

//Table
var options = {
    valueNames: [
        "id",
        "name",
        "file_desc",
        "file_path",
        "case",
        "date"
    ],
    page: perPage,
    pagination: true,
    plugins: [
        ListPagination({
            left: 2,
            right: 2
        })
    ]
};

// Init list
if (document.getElementById("customerList"))
    var customerList = new List("customerList", options).on("updated", function (list) {
        const search =  $('.search').val()
        list.matchingItems.length == 0 && search.length < 0 ?
            (document.getElementsByClassName("noresult")[0].style.display = "block") :
            (document.getElementsByClassName("noresult")[0].style.display = "none");
        var isFirst = list.i == 1;
        var isLast = list.i > list.matchingItems.length - list.page;
        // make the Prev and Nex buttons disabled on first and last pages accordingly
        (document.querySelector(".pagination-prev.disabled")) ? document.querySelector(".pagination-prev.disabled").classList.remove("disabled"): '';
        (document.querySelector(".pagination-next.disabled")) ? document.querySelector(".pagination-next.disabled").classList.remove("disabled"): '';
        if (isFirst) {
            document.querySelector(".pagination-prev").classList.add("disabled");
        }
        if (isLast) {
            document.querySelector(".pagination-next").classList.add("disabled");
        }
        if (list.matchingItems.length <= perPage) {
            document.querySelector(".pagination-wrap").style.display = "none";
        } else {
            document.querySelector(".pagination-wrap").style.display = "flex";
        }

        if (list.matchingItems.length == perPage) {
            document.querySelector(".pagination.listjs-pagination").firstElementChild.children[0].click()
        }

        if (list.matchingItems.length > 0 ) {
            document.getElementsByClassName("noresult")[0].style.display = "none";
        } else if(list.matchingItems.length <= 0 && $('.search').val().length <= 0){
            console.log('should enter if search is empty and list is empty');
        }else{
            document.getElementsByClassName("noresult")[0].style.display = "block";
            console.log('should not enter if search is fill');
        }
        
    });


const xhttp = new XMLHttpRequest();
xhttp.onload = function () {
  var json_records = JSON.parse(this.responseText);
  Array.from(json_records).forEach(raw => {
    customerList.add({
      id: `000${raw.id}`,
      name: raw.name,
      file_desc: raw.file_desc?.slice(0, 50),
      case: raw.cas.title_file,
      file_path: raw.file_path,
      date: timeAgo(new Date(raw.updated_at) - 3 * 60 * 1000)
    });
    customerList.sort('id', { order: "desc" });
    refreshCallbacks();
  });
  customerList.remove("id", '<a href="javascript:void(0);" class="fw-medium link-primary">...</a>');
  console.log(customerList)

//   document.getElementsByClassName('firstRaw').style.display = 'block'
}
xhttp.open("GET", "/documentJson");
xhttp.send();

// isCount = new DOMParser().parseFromString(
//     customerList.items.slice(-1)[0]._values.id,
//     "text/html"
// );

// var isValue = isCount.body.firstElementChild.innerHTML;

var idField = document.getElementById("id-field"),
    nameField = document.getElementById("name-field"),
    fileDescField = document.getElementById("file_desc-field"),
    caseField = document.getElementById("case-field"),
    fileField = document.getElementById("docs"),

    addBtn = document.getElementById("add-btn"),
    editBtn = document.getElementById("edit-btn"),
    removeBtns = document.getElementsByClassName("remove-item-btn"),
    editBtns = document.getElementsByClassName("edit-item-btn");

    let selectedGender = ''
    var genderRadios = document.querySelectorAll('input[name="gender"]');
    genderRadios.forEach(function (radio) {
        radio.addEventListener('change', function () {
            selectedGender = this.value; 
        });
    });
refreshCallbacks();
//filterContact("All");


// function filterContact(isValue) {
//     var values_status = isValue;
//     customerList.filter(function (data) {
//         var statusFilter = false;
//         matchData = new DOMParser().parseFromString(
//             data.values().status,
//             "text/html"
//         );
//         var status = matchData.body.firstElementChild.innerHTML;
//         if (status == "All" || values_status == "All") {
//             statusFilter = true;
//         } else {
//             statusFilter = status == values_status;
//         }
//         return statusFilter;
//     });

//     customerList.update();
// }

function updateList() {
    var values_status = document.querySelector("input[name=status]:checked").value;
    data = userList.filter(function (item) {
        var statusFilter = false;

        if (values_status == "All") {
            statusFilter = true;
        } else {
            statusFilter = item.values().sts == values_status;
        }
        return statusFilter;
    });
    userList.update();
}

if (document.getElementById("showModal")) {
    document.getElementById("showModal").addEventListener("show.bs.modal", function (e) {
        if (e.relatedTarget.classList.contains("edit-item-btn")) {
            document.getElementById("exampleModalLabel").innerHTML = window.translations.editDocument;
            document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";
            document.getElementById("add-btn").innerHTML = window.translations.editDocument;
        } else if (e.relatedTarget.classList.contains("add-btn")) {
            document.getElementById("exampleModalLabel").innerHTML = window.translations.addDocument;
            document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";
            document.getElementById("add-btn").innerHTML = window.translations.addDocument;
        } else {
            document.getElementById("exampleModalLabel").innerHTML = "List Customer";
            document.getElementById("showModal").querySelector(".modal-footer").style.display = "none";
        }
    });
    ischeckboxcheck();

    document.getElementById("showModal").addEventListener("hidden.bs.modal", function () {
        clearFields();
    });
}
document.querySelector("#customerList").addEventListener("click", function () {
    ischeckboxcheck();
});

var table = document.getElementById("customerTable");
// save all tr
var tr = table.getElementsByTagName("tr");
var trlist = table.querySelectorAll(".list tr");

var count = 11;

var forms = document.querySelectorAll('.tablelist-form')
Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener('submit', function (event) {
        console.log(form.checkValidity())
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            event.preventDefault();
            if (
                nameField.value !== "" &&
                fileDescField.value !== "" && !editlist
            ) {
                if(caseVal.getValue().value === ""){
                    Swal.fire({
                        title: window.translations.selecetCase,
                        showCloseButton: true
                    });
                }else{
                    console.log(form.elements['docs'].value);
                    const data = {
                        name: nameField.value,
                        file_desc: fileDescField.value,
                        case: caseVal.getValue().value,
                        docs: form.elements['docs'].value
                    }
                    $.ajax({
                        url: "/store-doc",
                        method: "POST",
                        data: JSON.stringify(data),
                        headers:{
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        // beforeSend: ()=>{
                        //     document.getElementById('add-btn').innerHTML = 
                        // },
                        beforeSend: ()=>{
                            $('#add-btn').html(`<div class="spinner-border text-primary" style='width:1rem; height:1rem;' role="status" ><span class="sr-only">loading...</span></div>`)
                        },
                        success: (res) =>{
                            toastr[res['alert-type']](res.message)
                            customerList.add({
                                id: `000${res.data.id}`,
                                name: res.data.name,
                                file_desc: res.data.file_desc,
                                file_path: res.data.file_path,
                                case: res.data.cas.title_file,
                                date: timeAgo(new Date(res.data.updated_at) - 3 * 60 * 1000)
                            });
                            customerList.sort('id', { order: "desc" });
                            document.getElementById("close-modal").click();
                            refreshCallbacks();
                            form.elements['docs'].value = ""
                            clearFields();
                            count++;
                        },
                        error: (xhr, status, error) => {
                            $('#add-btn').html(``)
                            $('#add-btn').text(window.translations.addDocument)
                            const err = xhr.responseJSON.errors
                            for(const key in err){
                                if(key === 'case'){
                                    Swal.fire({
                                        title: window.translations.selecetCase,
                                        showCloseButton: true
                                    });
                                }else{
                                    const input = event.target.elements[key] 
                                    if(err[key][0].split('.')[1] === 'required'){
                                        input.classList.add('is-invalid');
                                        $(input).next('.invalid-feedback').html(`<strong>this field are required</strong>`);
                                    }else if(err[key][0].split('.')[1] === 'unique'){
                                        input.classList.add('is-invalid');
                                        $(input).next('.invalid-feedback').html(`<strong>this field should be unique </strong>`);
                                    }else{
                                        input.classList.add('is-invalid');
                                        $(input).next('.invalid-feedback').html(`<strong>${err[key]}</strong>`);
                                    }
                                }
                            }
                        }
                    });
                }
            } else if (
                nameField.value !== "" &&
                fileDescField.value !== "" && editlist
            ){
                var editValues = customerList.get({
                    id: idField.value,
                });
                Array.from(editValues).forEach(function (x) {
                    isid = new DOMParser().parseFromString(x._values.id, "text/html");
                    var selectedid = isid.body.innerHTML;
                    if (selectedid == itemId) {
                        const data = {
                            name: nameField.value,
                            file_desc: fileDescField.value,
                            case: caseVal.getValue().value,
                            docs: form.elements['docs'].value
                        }
                        console.log(data)
                        $.ajax({
                            url: `/document/${parseInt(selectedid)}`,
                            method: "PUT",
                            data: JSON.stringify(data),
                            headers:{
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            beforeSend: ()=>{
                                $('#add-btn').html(`<div class="spinner-border text-primary" style='width:1rem; height:1rem;' role="status" ><span class="sr-only">loading...</span></div>`)
                            },
                            success: (res) =>{
                                toastr[res['alert-type']](res.message)
                                x.values({
                                    id: `000${res.data.id}`,
                                    name: res.data.name,
                                    file_desc: res.data.file_desc,
                                    file_path: res.data.file_path,
                                    case: res.data.cas.title_file,
                                });
                                document.getElementById("close-modal").click();
                                clearFields();
                            },
                            error: (xhr, status, error) => {
                                $('#add-btn').html(``)
                                $('#add-btn').text(window.translations.editDocument)
                                const err = xhr.responseJSON.errors
                                for(const key in err){
                                    console.log(key)
                                    const input = event.target.elements[key] 
                                    console.log(input)
                                    if(err[key][0].split('.')[1] === 'required'){
                                        input.classList.add('is-invalid');
                                        $(input).next('.invalid-feedback').html(`<strong>this field are required</strong>`);
                                    }else if(err[key][0].split('.')[1] === 'unique'){
                                        input.classList.add('is-invalid');
                                        $(input).next('.invalid-feedback').html(`<strong>this field should be unique </strong>`);
                                    }else{
                                        if(input.classList){
                                            input.classList.add('is-invalid');
                                            $(input).next('.invalid-feedback').html(`<strong>${err[key]}</strong>`);
                                        }
                                    }
                                }
                            }
                        })
                    }
                });
            }
        }
    }, false)
})



var caseVal = new Choices(caseField);
function isStatus(val) {
    switch (val) {
        case "Active":
            return (
                '<span class="badge bg-success-subtle text-success text-uppercase">' +
                val +
                "</span>"
            );
        case "Block":
            return (
                '<span class="badge bg-danger-subtle text-danger text-uppercase">' +
                val +
                "</span>"
            );
    }
}

function ischeckboxcheck() {
    Array.from(document.getElementsByName("checkAll")).forEach(function (x) {
        x.addEventListener("click", function (e) {
            if (e.target.checked) {
                e.target.closest("tr").classList.add("table-active");
            } else {
                e.target.closest("tr").classList.remove("table-active");
            }
        });
    });
}

function refreshCallbacks() {

    if($('.view-btn')){
        $('.view-btn').on('click', (e)=>{
            const itemId = e.target.closest("tr").children[1].innerText;
            window.location = `/show-doc/${itemId}`
        })
    }

    if($('.download-btn')){
        $('.download-btn').on('click', (e)=>{
            const itemId = e.target.closest("tr").children[1].innerText;
            const filePath = customerList.get('id', itemId)[0]._values.file_path
            window.location = `/uploadFile/${filePath}`
        })
    }

    if (removeBtns)
    Array.from(removeBtns).forEach(function (btn) {
        btn.addEventListener("click", function (e) {
            e.target.closest("tr").children[1].innerText;
            itemId = e.target.closest("tr").children[1].innerText;
            var itemValues = customerList.get({
                id: itemId,
            });

            Array.from(itemValues).forEach(function (x) {
                deleteid = new DOMParser().parseFromString(x._values.id, "text/html");
                var isElem = deleteid.body;
                var isdeleteid = deleteid.body.innerHTML;
                if (isdeleteid == itemId) {
                    document.getElementById("delete-record").addEventListener("click", function () {
                        if(itemId == x._values.id){
                            $.ajax({
                                url: `/doc-delete/${parseInt(isdeleteid)}`,
                                method: "DELETE",
                                headers:{
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': token
                                },
                                beforeSend: ()=>{
                                    $('#delete-record').html(`<div class="spinner-border text-primary" style='width:1rem; height:1rem;' role="status" ><span class="sr-only">loading...</span></div>`)
                                },
                                success: (res) =>{
                                    toastr[res['alert-type']](res.message)
                                    customerList.remove("id", isElem.innerHTML);
                                    document.getElementById("btn-close").click();
                                    $('#delete-record').html("")
                                    $('#delete-record').text(window.translations.yes)
                                },
                                error: (xhr, status, error) => console.log(error)
                            })
                        }
                    });
                }
            });
        });
    });

    if (editBtns)
        Array.from(editBtns).forEach(function (btn) {
            btn.addEventListener("click", function (e) {
                e.target.closest("tr").children[1].innerText;
                itemId = e.target.closest("tr").children[1].innerText;
                var itemValues = customerList.get({
                    id: itemId,
                });

                Array.from(itemValues).forEach(function (x) {
                    isid = new DOMParser().parseFromString(x._values.id, "text/html");
                    var selectedid = isid.body.innerHTML;
                    if (selectedid == itemId) {
                        editlist = true;
                        idField.value = selectedid;
                        nameField.value = x._values.name;
                        fileDescField.value = x._values.file_desc;

                        if (caseVal) caseVal.destroy();
                        caseVal = new Choices(caseField);
                        const selectedValue = caseVal.config.choices.find((elm)=> elm.label == x._values.case);
                        caseVal.setChoiceByValue(selectedValue.value);
                    }
                });
            });
        });
}


function clearFields() {
    nameField.value = "";
    fileDescField.value = "";
    caseVal.setChoiceByValue("")
    pondInstances.forEach(pondInstance => {
        pondInstance.removeFiles(); 
    });
    fileInput.removeFiles();

    editlist = false
}

function deleteMultiple() {
  ids_array = [];
  var items = document.getElementsByName('chk_child');
  Array.from(items).forEach(function (ele) {
    if (ele.checked == true) {
      var trNode = ele.parentNode.parentNode.parentNode;
      var id = trNode.querySelector('.id').innerHTML;
      ids_array.push(id);
    }
  });
  if (typeof ids_array !== 'undefined' && ids_array.length > 0) {
    if (confirm('Are you sure you want to delete this?')) {
        $.ajax({
            url: "/destroyMany-document",
            method: "DELETE",
            data: {ids: ids_array},
            headers:{
                'X-CSRF-TOKEN': token
            },
            success: (res)=>{
                toastr[res['alert-type']](res.message)
                Array.from(ids_array).forEach(function (id) {
                    customerList.remove("id", id);
                })
                document.getElementById('checkAll').checked = false;
            },
            error: (xhr, status, error) => console.log(error)
        })
    } else {
      return false;
    }
  } else {
    Swal.fire({
      title: 'Please select at least one checkbox',
      confirmButtonClass: 'btn btn-info',
      buttonsStyling: false,
      showCloseButton: true
    });
  }
}





document.querySelectorAll(".listjs-table").forEach(function(item){
    item.querySelector(".pagination-next").addEventListener("click", function () {
        (item.querySelector(".pagination.listjs-pagination")) ? (item.querySelector(".pagination.listjs-pagination").querySelector(".active")) ?
         item.querySelector(".pagination.listjs-pagination").querySelector(".active").nextElementSibling.children[0].click(): '': '';
    });
});

document.querySelectorAll(".listjs-table").forEach(function(item){
    item.querySelector(".pagination-prev").addEventListener("click", function () {
        (item.querySelector(".pagination.listjs-pagination")) ? (item.querySelector(".pagination.listjs-pagination").querySelector(".active")) ?
         item.querySelector(".pagination.listjs-pagination").querySelector(".active").previousSibling.children[0].click(): '': '';
    });
});




// data- attribute example
var attroptions = {
    valueNames: [
        'name',
        'born',
        {
            data: ['id']
        },
        {
            attr: 'src',
            name: 'image'
        },
        {
            attr: 'href',
            name: 'link'
        },
        {
            attr: 'data-timestamp',
            name: 'timestamp'
        }
    ]
};

// var attrList = new List('users', attroptions);
// attrList.add({
//     name: 'Leia',
//     born: '1954',
//     image: 'build/images/users/avatar-5.jpg',
//     id: 5,
//     timestamp: '67893'
// });

// // Existing List
// var existOptionsList = {
//     valueNames: ['contact-name', 'contact-message']
// };
// var existList = new List('contact-existing-list', existOptionsList);

// // Fuzzy Search list
// var fuzzySearchList = new List('fuzzysearch-list', {
//     valueNames: ['name']
// });

// // pagination list
// var paginationList = new List('pagination-list', {
//     valueNames: ['pagi-list'],
//     page: 3,
//     pagination: true
// });
function timeAgo(date) {
  const now = new Date();
  const diff = (now - date) / 1000; // Difference in seconds

    let rtf = new Intl.RelativeTimeFormat('ar', { numeric: 'auto' });
    if(sessionStorage.getItem('lang') === "fr"){
        rtf = new Intl.RelativeTimeFormat('fr', { numeric: 'auto' });
    }

  if (diff < 60) {
    return rtf.format(Math.floor(-diff), 'seconds');
  } else if (diff < 3600) {
    return rtf.format(Math.floor(-diff / 60), 'minutes');
  } else if (diff < 86400) {
    return rtf.format(Math.floor(-diff / 3600), 'hours');
  } else {
    return rtf.format(Math.floor(-diff / 86400), 'days');
  }
}

// Example usage:
// const date = new Date(Date.now() - 3 * 60 * 1000); // 3 minutes ago
// console.log(timeAgo(date)); // "3 minutes ago"
