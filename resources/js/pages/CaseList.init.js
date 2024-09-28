/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: list Js File
*/


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
        "serial_number",
        "name",
        "client",
        "court",
        "judge",
        "status",
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
      id: raw.id,
      serial_number: raw.serial_number,
      name: raw.title_file,
      client: raw.client.name,
      court: raw.court.name,
      judge: raw.judge.name,
      status: isStatus({id: raw.id, name:raw.status}),
    });
    customerList.sort('id', { order: "desc" });
    refreshCallbacks();
  });
  customerList.remove("id", '<a href="javascript:void(0);" class="fw-medium link-primary">test</a>');
//   $('.name').closest("tr").css('visibility', 'visible');

//   document.getElementsByClassName('firstRaw').style.display = 'block'
}
xhttp.open("GET", "/caseJson");
xhttp.send();

isCount = new DOMParser().parseFromString(
    customerList.items.slice(-1)[0]._values.id,
    "text/html"
);

var isValue = isCount.body.firstElementChild.innerHTML;

var idField = document.getElementById("id-field"),
    nameField = document.getElementById("name-field"),
    contact_infoField = document.getElementById("contact_info-field"),
    genderField = document.getElementById("gender-field"),
    addressField = document.getElementById("address-field"),
    cinField = document.getElementById("cin-field"),
    addBtn = document.getElementById("add-btn"),
    editBtn = document.getElementById("edit"),
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
            document.getElementById("exampleModalLabel").innerHTML = "add CLient";
            document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";
            document.getElementById("add-btn").innerHTML = "Update";
        } else if (e.relatedTarget.classList.contains("add-btn")) {
            document.getElementById("exampleModalLabel").innerHTML = "Add Customer";
            document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";
            document.getElementById("add-btn").innerHTML = "Add Customer";
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



function isStatus(val) {
    switch (val.name) {
        case "Open":
            return (
                `<button type="button" data-bs-toggle="dropdown" id=${val.id} aria-haspopup="true" aria-expanded="false" class="btn btn-sm dropdown-toggle bg-success-subtle text-success " >${window.translations.open}</button>
                <div class="dropdown-menu cursor-pointer">
                    <a class="dropdown-item" onclick="handleStatusChange('Pending', ${val.id})">${window.translations.pending}</a>
                    <a class="dropdown-item" onclick="handleStatusChange('Closed', ${val.id})">${window.translations.closed}</a>
                    <a class="dropdown-item" onclick="handleStatusChange('Open', ${val.id})">${window.translations.open}</a>
                </div>`
            );
        case "Pending":
            return (
                `<button type="button" data-bs-toggle="dropdown" id=${val.id} aria-haspopup="true" aria-expanded="false" class="btn btn-sm dropdown-toggle bg-primary-subtle text-primary " >${window.translations.pending}</button>
                <div class="dropdown-menu cursor-pointer">
                    <a class="dropdown-item" onclick="handleStatusChange('Pending', ${val.id})">${window.translations.pending}</a>
                    <a class="dropdown-item" onclick="handleStatusChange('Closed', ${val.id})">${window.translations.closed}</a>
                    <a class="dropdown-item" onclick="handleStatusChange('Open', ${val.id})">${window.translations.open}</a>
                </div>`
            );
        case "Closed":
            return (
                `<button type="button" data-bs-toggle="dropdown" id=${val.id} aria-haspopup="true" aria-expanded="false" class="btn btn-sm dropdown-toggle bg-danger-subtle text-danger " >${window.translations.closed}</button>
                <div class="dropdown-menu cursor-pointer">
                    <a class="dropdown-item" onclick="handleStatusChange('Pending', ${val.id})">${window.translations.pending}</a>
                    <a class="dropdown-item" onclick="handleStatusChange('Closed', ${val.id})">${window.translations.closed}</a>
                    <a class="dropdown-item" onclick="handleStatusChange('Open', ${val.id})">${window.translations.open}</a>
                </div>`
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
    
    if($('.view')){
        $('.view').on('click', (e)=>{
            const itemId = e.target.closest("tr").children[1].innerText;
            window.location = `/cas/${itemId}`
        })
    }

    if($('.edit')){
        $('.edit').on('click', (e)=>{
            const itemId = e.target.closest("tr").children[1].innerText;
            window.location = `/case-edit/${itemId}`
        })
    }

    
    if(editBtn){
        Array.from(editBtn).forEach(function (btn) {
            btn.addEventListener("click", function (e) {
                const itemId = e.target.closest("tr").children[1].innerText;
                var itemValues = customerList.get({
                    id: itemId,
                });

            })
        })
    }


    // if (removeBtns)
    // Array.from(removeBtns).forEach(function (btn) {
    //     btn.addEventListener("click", function (e) {

    //         itemId = e.target.closest("tr").children[1].innerText;
    //         var itemValues = customerList.get({
    //             id: itemId,
    //         });


    //         Array.from(itemValues).forEach(function (x) {
    //             deleteid = new DOMParser().parseFromString(x._values.id, "text/html");
    //             var isElem = deleteid.body;
    //             var isdeleteid = deleteid.body.innerHTML;
    //             const modal = new bootstrap.Modal(document.getElementById('deleteRecordModal'))
    //             if (isdeleteid == itemId) {

    //                 $("#delete-record").on("click", function () {
    //                     if(itemId == x._values.id){
    //                         $.ajax({
    //                             url: `/case-delete/${isdeleteid}`,
    //                             method: "DELETE",
    //                             headers:{
    //                                 'Content-Type': 'application/json',
    //                                 'X-CSRF-TOKEN': token
    //                             },
    //                             success: (res) =>{
    //                                 toastr[res['alert-type']](res.message)
    //                                 customerList.remove("id", isElem.innerHTML);
    //                                 console.log(document.getElementById("btn-close"));
    //                                 document.getElementById("btn-close").click();
    //                                 modal.hide()
    //                                 ct = 0
                                    
    //                             },
    //                             error: (xhr, status, error) => console.log(error)
    //                         })
    //                     }
    //                 });
    //             }
    //         });
    //     });
    // });


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
                                url: `/case-delete/${isdeleteid}`,
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
            url: "/destroyMany-case",
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

