
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
        "contact",
        "gender",
        "court",
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
      contact: raw.contact_info,
      gender: raw.gender === 'Male' ? window.translations.male : window.translations.female, 
      court: raw.court.name,
    });
    customerList.sort('id', { order: "desc" });
    refreshCallbacks();
  });
  customerList.remove("id", '<a href="javascript:void(0);" class="fw-medium link-primary">...</a>');
  console.log(customerList)

//   document.getElementsByClassName('firstRaw').style.display = 'block'
}
xhttp.open("GET", "/judgeJson");
xhttp.send();

// isCount = new DOMParser().parseFromString(
//     customerList.items.slice(-1)[0]._values.id,
//     "text/html"
// );

// var isValue = isCount.body.firstElementChild.innerHTML;

var idField = document.getElementById("id-field"),
    nameField = document.getElementById("name-field"),
    contact_infoField = document.getElementById("contact_info-field"),
    genderField = document.getElementById("gender-field"),
    courtsField = document.getElementById("court-field"),
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
            document.getElementById("exampleModalLabel").innerHTML = window.translations.editJudge;
            document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";
            document.getElementById("add-btn").innerHTML = window.translations.editJudge;
        } else if (e.relatedTarget.classList.contains("add-btn")) {
            document.getElementById("exampleModalLabel").innerHTML = window.translations.addJudge;
            document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";
            document.getElementById("add-btn").innerHTML = window.translations.addJudge;
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
                contact_infoField.value !== "" && !editlist
            ) {

                const initGender = document.querySelector('input[name="gender"]:checked')
                console.log(initGender)
                const data = {
                    name: nameField.value,
                    contact_info: contact_infoField.value,
                    gender: selectedGender ? selectedGender : initGender.value,
                    court: courtsField.value,
                }

                console.log(data)
                
                $.ajax({
                    url: "/store-judge",
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
                        console.log(res.data.gender)
                        console.log(res.data.gender === "Male" ? window.translations.male : window.translations.female), 
                        customerList.add({
                            id: `000${res.data.id}`,
                            name: res.data.name,
                            contact: res.data.contact_info,
                            gender: res.data.gender === "Male" ? window.translations.male : window.translations.female, 
                            court : res.data.court.name,
                        });
                        customerList.sort('id', { order: "desc" });
                        document.getElementById("close-modal").click();
                        refreshCallbacks();
                        clearFields();
                        count++;
                    },
                    error: (xhr, status, error) => {
                        $('#add-btn').html(``)
                        $('#add-btn').text(window.translations.addJudge)
                        const err = xhr.responseJSON.errors
                        for(const key in err){
                            console.log(key)
                            if(key === 'court'){
                                Swal.fire({
                                    title: window.translations.selectCourt,
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
            } else if (
                nameField.value !== "" &&
                contact_infoField.value !== "" &&
                courtsField.value !== "" && editlist
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
                            contact_info: contact_infoField.value,
                            gender: selectedGender ? selectedGender : x._values.gender,
                            court: courtsField.value,
                        }
                        console.log(data)
                        $.ajax({
                            url: `/judge/${parseInt(selectedid)}`,
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
                                    contact: res.data.contact_info,
                                    gender: res.data.gender === 'Male' ? window.translations.male : window.translations.female, 
                                    court: res.data.court.name,
                                });
                                document.getElementById("close-modal").click();
                                clearFields();
                            },
                            error: (xhr, status, error) => {
                                $('#add-btn').html(``)
                                $('#add-btn').text(window.translations.editJudge)
                                const err = xhr.responseJSON.errors
                                console.log(err)
                                if(!err){
                                    clearFields();
                                    console.log('hello')
                                    toastr['error']("you can't modify the default court")
                                    document.getelementbyId("close-modal").click();
                                }else{
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
                            }
                        })
                    }
                });
            }
        }
    }, false)
})



var courtVal = new Choices(courtsField);
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
                                url: `/judge-delete/${parseInt(isdeleteid)}`,
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
                                error: (xhr, status, error) => {
                                    clearFields();
                                    toastr['error']("you can't modify the default court")
                                    document.getelementbyId("close-modal").click();
                                }
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
                        contact_infoField.value = x._values.contact;
                        if(x._values.gender === window.translations.male){
                            document.getElementById('gender-male').checked = true
                        }else{
                            document.getElementById('gender-female').checked = true
                        }

                        if (courtVal) courtVal.destroy();
                        courtVal = new Choices(courtsField);
                        val = new DOMParser().parseFromString(x._values.court, "text/html");
                        const selectedValue = courtVal.config.choices.find((elm)=> elm.label == x._values.court);
                        courtVal.setChoiceByValue(selectedValue.value);
                    }
                });
            });
        });
}


function clearFields() {
    nameField.value = "";
    contact_infoField.value = "";
    genderField.value = "";
    courtsField.value = "";
    for (let i = 0; i < genderRadios.length; i++) {
        if(genderRadios[i].value === 'male'){
            genderRadios[i].checked = true;
        }
        genderRadios[i].checked = false;
    }
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
            url: "/destroyMany-judge",
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
            error: (xhr, status, error) => {
                clearfields();
                toastr['error']("you can't modify the default court")
                document.getelementbyId("close-modal").click();
            }
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