/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: CRM-contact Js File
*/


// list js
const tk = $('meta[name="csrf-token"]').attr('content');
function timeConvert(time) {
    var d = new Date(time);
    time_s = (d.getHours() + ':' + d.getMinutes());
    var t = time_s.split(":");
    var hours = t[0];
    var minutes = t[1];
    var newformat = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12;
    minutes = minutes < 10 ? '0' + minutes : minutes;
    return (hours + ':' + minutes + '' + newformat);
}

function formatDate(date) {
    var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    var d = new Date(date),
        month = '' + monthNames[(d.getMonth())],
        day = '' + d.getDate(),
        year = d.getFullYear();
    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;
    return [day + " " + month, year].join(', ');
};

var checkAll = document.getElementById("checkAll");
if (checkAll) {
  checkAll.onclick = function () {
    var checkboxes = document.querySelectorAll('.form-check-all input[type="checkbox"]');
    var checkedCount = document.querySelectorAll('.form-check-all input[type="checkbox"]:checked').length;
    for (var i = 0; i < checkboxes.length; i++) {
      checkboxes[i].checked = this.checked;
      if (checkboxes[i].checked) {
        
          checkboxes[i].closest("tr").classList.add("table-active");
      } else {
          checkboxes[i].closest("tr").classList.remove("table-active");
      }
    }

    (checkedCount > 0) ? document.getElementById("remove-actions").style.display = 'none' : document.getElementById("remove-actions").style.display = 'block';
  };
}

var perPage = 10;
var editlist = false;

//Table
var options = {
    valueNames: [
        "id",
        "name",
        "email",
        "phone",
        "address",
        "tag",
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

var contactList = new List("contactList", options).on("updated", function (list) {
    list.matchingItems.length == 0 ?
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

    if (list.matchingItems.length > 0) {
        document.getElementsByClassName("noresult")[0].style.display = "none";
    } else {
        document.getElementsByClassName("noresult")[0].style.display = "block";
    }
});


contactList.items.forEach((elm) =>{
    let htmlContant = ''
    var elements = document.querySelectorAll(`.tags-${elm._values.id} span.badge.bg-primary-subtle.text-primary`);
    elements.forEach(function(element) {
        htmlContant += element.outerHTML;
    });

    elm._values.tag = htmlContant
});


// contactList.sort('id', { order: "desc" });


// const xhttp = new XMLHttpRequest();
// xhttp.onload = function () {
//     var json_records = JSON.parse(this.responseText);
//     Array.from(json_records).forEach(function (raw){
//         var tags = raw.tags;
//         var tagHtml = '';
//         Array.from(tags).forEach((tag, index) => {
//             tagHtml += '<span class="badge bg-primary-subtle text-primary me-1">'+tag+'</span>'
//         })

//         contactList.add({
//             id: `<a href="javascript:void(0);" class="fw-medium link-primary">#VZ${raw.id}</a>`,
//             name: '<div class="d-flex align-items-center">\
//             <div class="flex-shrink-0"><img src="'+raw.name[0]+'" alt="" class="avatar-xs rounded-circle"></div>\
//             <div class="flex-grow-1 ms-2 name">'+raw.name[1]+'</div>\
//             </div>',
//             company_name: raw.company_name,
//             desc: raw.desc,
//             designation: raw.designation,
//             date: formatDate(raw.date)+' <small class="text-muted">'+timeConvert(raw.date)+'</small>',
//             email_id: raw.email_id,
//             phone: raw.phone,
//             lead_score: raw.lead_score,
//             tags: tagHtml,
//         });
//         contactList.sort('id', { order: "desc" });
//         refreshCallbacks();
//     });
// }
// xhttp.open("GET", "build/json/contact-list.json");
// xhttp.send();

isCount = new DOMParser().parseFromString(
    contactList.items.slice(-1)[0]._values.id,
    "text/html"
);



var idField = document.getElementById("id-field"),
    customerNameField = document.getElementById("customername-field"),
    designationField = document.getElementById("address-field"),
    email_idField = document.getElementById("email_id-field"),
    phoneField = document.getElementById("phone-field"),
    addBtn = document.getElementById("add-btn"),
    editBtn = document.getElementById("edit-btn"),
    removeBtns = document.getElementsByClassName("remove-item-btn"),
    editBtns = document.getElementsByClassName("edit-item-btn");
    viewBtns = document.getElementsByClassName("view-item-btn");
refreshCallbacks();

document.getElementById("showModal").addEventListener("show.bs.modal", function (e) {
    if (e.relatedTarget.classList.contains("edit-item-btn")) {
        document.getElementById("exampleModalLabel").innerHTML = window.translations.editContact;
        document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";
        document.getElementById("add-btn").innerHTML = window.translations.edit;
    } else if (e.relatedTarget.classList.contains("add-btn")) {
        document.getElementById("exampleModalLabel").innerHTML = window.translations.addContact;
        document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";
        document.getElementById("add-btn").innerHTML = window.translations.addContact;
    } else {
        document.getElementById("exampleModalLabel").innerHTML = "List Contact";
        document.getElementById("showModal").querySelector(".modal-footer").style.display = "none";
    }
});
ischeckboxcheck();

document.getElementById("showModal").addEventListener("hidden.bs.modal", function (e) {
    clearFields();
});

document.querySelector("#contactList").addEventListener("click", function () {
    ischeckboxcheck();
});

var table = document.getElementById("customerTable");
// save all tr
var tr = table.getElementsByTagName("tr");
var trlist = table.querySelectorAll(".list tr");

// date & time
var dateValue = new Date().toUTCString().slice(5, 16);
function currentTime() {
    var ampm = new Date().getHours() >= 12 ? "PM" : "AM";
    var hour =
        new Date().getHours() > 12
            ? new Date().getHours() % 12
            : new Date().getHours();
    var minute =
        new Date().getMinutes() < 10
            ? "0" + new Date().getMinutes()
            : new Date().getMinutes();
    if (hour < 10) {
        return "0" + hour + ":" + minute + " " + ampm;
    } else {
        return hour + ":" + minute + " " + ampm;
    }
}
setInterval(currentTime, 1000);


// multiple Remove CancelButton
var tagInputField = new Choices('#taginput-choices', {
      removeItemButton: true,
    }
);
JSON.stringify
JSON.parse
var tagInputFieldValue = tagInputField.getValue(true);
var tagHtmlValue = '';
Array.from(tagInputFieldValue).forEach((tag, index) => {
    tagHtmlValue += '<span class="badge bg-primary-subtle text-primary me-1">'+tag+'</span>'
})
var forms = document.querySelectorAll('.tablelist-form')
Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            event.preventDefault();
            if (customerNameField.value !== "" &&
                email_idField.value !== "" &&
                phoneField.value !== "" &&
                designationField.value !== "" && !editlist) {

                var tagInputFieldValue = tagInputField.getValue(true);
                var tagHtmlValue = '';
                Array.from(tagInputFieldValue).forEach((tag, index) => {
                    tagHtmlValue += '<span class="badge bg-primary-subtle text-primary me-1">' + tag + '</span>'
                })
                $.ajax({
                    url: "/contact",
                    method: 'POST',
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': tk
                    },
                    data: JSON.stringify({
                        name: customerNameField.value,
                        email: email_idField.value,
                        phone: phoneField.value,
                        address: designationField.value,
                        tag: tagInputFieldValue
                    }),
                    success: (res)=>{
                        document.getElementById("close-modal").click();
                        clearFields();
                        refreshCallbacks();
                        toastr[res['alert-type']](res.message)
                        window.location.reload();
                    },
                    error: (xhr, status, error) => console.log(error)
                })

            }else if (customerNameField.value !== "" &&
            email_idField.value !== "" &&
            phoneField.value !== "" &&
            designationField.value !== "" && editlist) {
                var tagInputFieldValue = tagInputField.getValue(true);
                Array.from(tagInputFieldValue).forEach((tag, index) => {
                    tagHtmlValue += '<span class="badge bg-primary-subtle text-primary me-1">' + tag + '</span>'
                })
                $.ajax({
                    url: `/contact/${idField.value}`,
                    method: 'PUT',
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': tk
                    },
                    data: JSON.stringify({
                        name: customerNameField.value,
                        email: email_idField.value,
                        phone: phoneField.value,
                        address: designationField.value,
                        tag: tagInputFieldValue
                    }),
                    success: (res)=>{
                        document.getElementById("close-modal").click();
                        clearFields();
                        refreshCallbacks();
                        window.location.reload();
                        toastr[res['alert-type']](res.message)
                    },
                    error: (xhr, status, error) => console.log(error)
                })
            }
        }
    }, false)
})


function ischeckboxcheck() {
    Array.from(document.getElementsByName("chk_child")).forEach(function (x) {
        x.addEventListener("change", function (e) {
            if (x.checked == true) {
                e.target.closest("tr").classList.add("table-active");
            } else {
                e.target.closest("tr").classList.remove("table-active");
            }
  
            var checkedCount = document.querySelectorAll('[name="chk_child"]:checked').length;
            if (e.target.closest("tr").classList.contains("table-active")) {
                (checkedCount > 0) ? document.getElementById("remove-actions").style.display = 'block': document.getElementById("remove-actions").style.display = 'none';
            } else {
                (checkedCount > 0) ? document.getElementById("remove-actions").style.display = 'block': document.getElementById("remove-actions").style.display = 'none';
            }
        });
    });
}

function refreshCallbacks() {
    if(removeBtns){
        Array.from(removeBtns).forEach(function (btn) {
            btn.addEventListener("click", function (e) {
                e.target.closest("tr").children[0].innerText;
                itemId = e.target.closest("tr").children[0].innerText;
                var itemValues = contactList.get({
                    id: itemId,
                });

                Array.from(itemValues).forEach(function (x) {
                    document.getElementById("delete-record").addEventListener("click", function () {
                        $.ajax({
                            url: `/contact/${itemId}`,
                            method: 'DELETE',
                            headers:{
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': tk
                            },
                            success: (res)=>{
                                document.getElementById("deleteRecord-close").click();
                                clearFields();
                                refreshCallbacks();
                                window.location.reload();
                                toastr[res['alert-type']](res.message)
                            },
                            error: (xhr, status, error) => console.log(error)
                        })
                    })
                });
            });
        });
    }

    if(editBtns){
        Array.from(editBtns).forEach(function (btn) {
            btn.addEventListener("click", function (e) {
                e.target.closest("tr").children[0].innerText;
                itemId = e.target.closest("tr").children[0].innerText;
                var itemValues = contactList.get({
                    id: itemId,
                });
    
                Array.from(itemValues).forEach(function (x) {
                    // isid = new DOMParser().parseFromString(x._values.id, "text/html");
                    var selectedid = parseInt(x._values.id);
                    var tagBadge = new DOMParser().parseFromString(x._values.tag, "text/html").body.querySelectorAll("span.badge");
                    if (selectedid == itemId) {
                        editlist = true;
                        idField.value = selectedid;
                        customerNameField.value = new DOMParser().parseFromString(x._values.name, "text/html").body.querySelector(".name").innerHTML;
                        designationField.value = x._values.address;
                        email_idField.value = x._values.email;
                        phoneField.value = x._values.phone;
                        if(tagBadge){
                            Array.from(tagBadge).forEach((item) => {
                                tagInputField.setChoiceByValue(item.id);
                            })
                        }
                        
                    }
                });
            });
        });
    }

    Array.from(viewBtns).forEach(function (btn) {
        btn.addEventListener("click", function (e) {
            e.target.closest("tr").children[1].innerText;
            itemId = e.target.closest("tr").children[1].innerText;
            var itemValues = contactList.get({
                id: itemId,
            });

            Array.from(itemValues).forEach(function (x) {
                isid = x._values.id;
                if (true) {
                    var codeBlock = `
                        <div class="card-body text-center">
                            <div class="position-relative d-inline-block">
                                <span class="contact-active position-absolute rounded-circle bg-success"><span
                                        class="visually-hidden"></span>
                            </div>
                            <h5 class="mt-4 mb-1">${new DOMParser().parseFromString(x._values.name, "text/html").body.querySelector(".name").innerHTML}</h5>
                            <p class="text-muted">${x._values.company_name}</p>

                            <ul class="list-inline mb-0">
                                <li class="list-inline-item avatar-xs">
                                    <a href="javascript:void(0);"
                                        class="avatar-title bg-success-subtle text-success fs-15 rounded">
                                        <i class="ri-phone-line"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item avatar-xs">
                                    <a href="javascript:void(0);"
                                        class="avatar-title bg-danger-subtle text-danger fs-15 rounded">
                                        <i class="ri-mail-line"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item avatar-xs">
                                    <a href="javascript:void(0);"
                                        class="avatar-title bg-warning-subtle text-warning fs-15 rounded">
                                        <i class="ri-question-answer-line"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h6 class="text-muted text-uppercase fw-semibold mb-3">Personal Information</h6>
                            <p class="text-muted mb-4">${x._values.desc}</p>
                            <div class="table-responsive table-card">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="fw-medium" scope="row">Designation</td>
                                            <td>${x._values.designation}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium" scope="row">Email ID</td>
                                            <td>${x._values.email}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium" scope="row">Phone No</td>
                                            <td>${x._values.phone}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium" scope="row">Lead Score</td>
                                            <td>${x._values.lead_score}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium" scope="row">Tags</td>
                                            <td>${x._values.tags}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium" scope="row">Last Contacted</td>
                                            <td>${x._values.date} <small class="text-muted"></small></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>`;
                    document.getElementById('contact-view-detail').innerHTML = codeBlock;
                }
            });
        });
    });
}

function clearFields() {
    customerNameField.value = '',
    designationField.value = '',
    email_idField.value = '',
    phoneField.value = '',
    tagInputField.removeActiveItems();
    tagInputField.setChoiceByValue("0");
}

// Delete All Records
function deleteMultiple(){
    ids_array = [];
    var items = document.getElementsByName('chk_child');
    for (i = 0; i < items.length; i++) {
        if (items[i].checked == true) {
            var trNode = items[i].parentNode.parentNode.parentNode;
            var id = trNode.querySelector("td a").innerHTML;
            ids_array.push(id);
        }
    }

    if(typeof ids_array !== 'undefined' && ids_array.length > 0){
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn btn-primary w-xs me-2 mt-2',
            cancelButtonClass: 'btn btn-danger w-xs mt-2',
            confirmButtonText: "Yes, delete it!",
            buttonsStyling: false,
            showCloseButton: true
        }).then(function (result) {
            if (result.value) {
                for (i = 0; i < ids_array.length; i++) {
                    contactList.remove("id", `<a href="javascript:void(0);" class="fw-medium link-primary">${ids_array[i]}</a>`);
                }
                document.getElementById("remove-actions").style.display = 'none';
                document.getElementById("checkAll").checked = false;
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Your data has been deleted.',
                    icon: 'success',
                    confirmButtonClass: 'btn btn-info w-xs mt-2',
                    buttonsStyling: false
                });
            }
        });
    }else{
        Swal.fire({
            title: 'Please select at least one checkbox',
            confirmButtonClass: 'btn btn-info',
            buttonsStyling: false,
            showCloseButton: true
        });
    }
}

document.querySelector(".pagination-next").addEventListener("click", function () {
    (document.querySelector(".pagination.listjs-pagination")) ? (document.querySelector(".pagination.listjs-pagination").querySelector(".active")) ?
    document.querySelector(".pagination.listjs-pagination").querySelector(".active").nextElementSibling.children[0].click(): '': '';
});
document.querySelector(".pagination-prev").addEventListener("click", function () {
    (document.querySelector(".pagination.listjs-pagination")) ? (document.querySelector(".pagination.listjs-pagination").querySelector(".active")) ?
    document.querySelector(".pagination.listjs-pagination").querySelector(".active").previousSibling.children[0].click(): '': '';
});