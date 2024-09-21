/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: todo init js
*/
let statusField = document.getElementById("task-status-input");
statusVal = new Choices(statusField, {
    searchEnabled: false,
});


let priorityField = document.getElementById("priority-field");
priorityVal = new Choices(priorityField, {
    searchEnabled: false,
});

const tokenize = $("meta[name='csrf-token']").attr('content');
const dateInput = document.getElementById("task-duedate-input")
let editList = false;

var todoList = [];
$.ajax({
    url: '/getAll',
    method: "GET",
    datatype: 'json',
    success: (res)=>{
        todoList = res;
        drawList(todoList);
    },
    error: (xhr, status, error)=> console.log(error)
})
editList = false;


flatpickr("#task-duedate-input", {
    dateFormat: "d M, Y",
});

Array.from(document.getElementsByClassName("createTask")).forEach(function (elem) {
    elem.addEventListener("click", function () {
        document.getElementById("createTaskLabel").innerHTML = window.translations.createTask;
        document.getElementById("addNewTodo").innerHTML = window.translations.createTask;
        clearFields();
    });
});





// add & edit task list
document.getElementById("creattask-form").addEventListener("submit", function (e) {
    e.preventDefault();
    var inputTitle = document.getElementById('task-title-input').value,
        inputDate = document.getElementById('task-duedate-input').value
        inputDesc = document.getElementById('task-description-input').value
    var statusInputFieldValue = statusVal.getValue(true);
    var priorityInputFieldValue = priorityVal.getValue(true);


    var errorMsg = document.getElementById("task-error-msg");
    
    var text;
    if(inputTitle.length == 0){
    text = "Please enter task name";
        errorMsg.style.display = "block";
    errorMsg.innerHTML = text;
    return false;
    }
    if(statusInputFieldValue == ""){
        text = "Please select task status";
        errorMsg.style.display = "block";
        errorMsg.innerHTML = text;
        return false;
    }
    if(priorityInputFieldValue == ""){
        text = "Please select task priority";
        errorMsg.style.display = "block";
        errorMsg.innerHTML = text;
        return false;
    }
    if(inputDate.length == 0){
        text = "Please select due date";
        errorMsg.style.display = "block";
        errorMsg.innerHTML = text;
        return false;
    }
    
    if (inputTitle !== "" && statusInputFieldValue !== "" && priorityInputFieldValue !== "" && !editList) {
        let newTodo = {
            'title': inputTitle,
            'description': inputDesc,
            'dueDate': inputDate,
            'status': statusInputFieldValue,
            'priority': priorityInputFieldValue
        };
        $.ajax({
            url: '/todo',
            method: "POST",
            headers:{
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': tokenize
            },
            beforeSend: ()=>{
                $('#addNewTodo').html(`<div class="spinner-border text-light" style='width:1rem; height:1rem;' role="status" ><span class="sr-only">loading...</span></div>`)
            },
            data: JSON.stringify(newTodo),
            success: (res) => {
                todoList.push(res)
                sortElementsById('asc');
                editList = false;
                document.getElementById("createTaskBtn-close").click();
                // $('#delete-record').html("")
                // $('#delete-record').text(window.translations.yes)
            },
            error: (xhr, status, error) => console.log(error)
        })

    } else if (inputTitle !== "" && statusInputFieldValue !== "" && priorityInputFieldValue !== "" && editList) {
        var getEditid = 0;
        getEditid = document.getElementById("taskid-input").value;
        console.log(getEditid)
        var editObj = {
            'title': inputTitle,
            'description': inputDesc,
            'dueDate': inputDate,
            'status': statusInputFieldValue,
            'priority': priorityInputFieldValue
        }
        $.ajax({
            url: `/todo/${getEditid}`,
            method: "PUT",
            headers:{
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': tokenize
            },
            data: JSON.stringify(editObj),
            beforeSend: ()=>{
                $('#addNewTodo').html(`<div class="spinner-border text-light" style='width:1rem; height:1rem;' role="status" ><span class="sr-only">loading...</span></div>`)
            },
            success: (res) => {
                // window.location.reload()
                todoList = todoList.map(function (item) {
                    if (item.id == getEditid) {
                        if (statusVal.getValue(true) == "Completed") {
                            item.checkedElem = true
                        } else {
                            item.checkedElem = false
                        }
                    
                    console.log(res)
                        return res;
                    }
                    return item;
                });
                console.log
                load(todoList)
                editList = false;
                document.getElementById("createTaskBtn-close").click();
            },
            error: (xhr, status, error) => console.log(error)
        })

    }

    load(todoList)
    return true;
});


function fetchIdFromObj(todo) {
    return parseInt(todo.id);
}

function findNextId() {
    if (todoList.length === 0) {
        return 0;
    }
    var lastElementId = fetchIdFromObj(todoList[todoList.length - 1]),
        firstElementId = fetchIdFromObj(todoList[0]);
    return (firstElementId >= lastElementId) ? (firstElementId + 1) : (lastElementId + 1);
}

function clearFields() {
    document.getElementById('task-title-input').value = '';
    document.getElementById('task-duedate-input').value = '';
    document.getElementById('task-description-input').value = '';



    var errorMsg = document.getElementById("task-error-msg");
    errorMsg.style.display = "none";

    statusVal.removeActiveItems();
    statusVal.setChoiceByValue("New");
    priorityVal.removeActiveItems();
    priorityVal.setChoiceByValue("");
}


document.getElementById('createTask').addEventListener('hidden.bs.modal', event => {
    editList = false;
    clearFields();
});

function sortElementsById(order="desc") {
    var manyTodos = todoList.sort(function (a, b) {
        var x = fetchIdFromObj(a);
        var y = fetchIdFromObj(b);
        if(order === 'asc'){
            return  y-x
        }
        if(order === 'desc'){
            return x-y
        }
    })
    load(manyTodos);
}

function sortElementsByName() {
    var manyTodos = todoList.sort(function (a, b) {
        var x = a.title.toLowerCase();
        var y = b.title.toLowerCase();
        if (x < y) {
            return -1;
        }
        if (x > y) {
            return 1;
        }
        return 0;
    })
    load(manyTodos);
}

// Search product list
var searchTaskList = document.getElementById("searchTaskList");
searchTaskList.addEventListener("keyup", function () {
    var inputVal = searchTaskList.value.toLowerCase();
    function filterItems(arr, query) {
        console.log(arr, query)
        return arr.filter(function (el) {
            return el.title.toLowerCase().indexOf(query.toLowerCase()) !== -1
        })
    }

    var filterData = filterItems(todoList, inputVal);
    if (filterData.length == 0) {
        document.getElementById("noresult").style.display = "block";
        document.getElementById("todo-task").style.display = "none";
    } else {
        document.getElementById("noresult").style.display = "none";
        document.getElementById("todo-task").style.display = "block";
    }

    load(filterData);
});

function loadList(manyTodos) {
    function elmLoader() {
        console.log(manyTodos)
        document.getElementById("elmLoader").innerHTML = '';
        drawList(manyTodos);
    }
    elmLoader();
}

var drake = dragula([document.getElementById("task-list")], {
    moves: function (el, container, handle) {
        return handle.classList.contains('task-handle');
    }
});

var scroll = autoScroll([
    document.querySelector("#todo-content"),
], {
    margin: 20,
    maxSpeed: 100,
    scrollWhenOutside: true,
    autoScroll: function () {
        return this.down && drake.dragging;
    }
});

function drawList(manyTodos) {
    document.getElementById("task-list").innerHTML = "";
    Array.from(manyTodos).forEach(function (singleTodo) {
        var checkinput = singleTodo.status == 'Completed' ? "checked" : "";
        document.getElementById("task-list").innerHTML +=
            '<tr>\
            <td>\
                <div class="d-flex align-items-start">\
                    <div class="flex-shrink-0 me-3">\
                        <div class="task-handle px-1 bg-light rounded">: :</div>\
                    </div>\
                    <div class="flex-grow-1">\
                        <div class="form-check">\
                            <input class="form-check-input" type="checkbox" value="'+ singleTodo.id + '" id="todo' + singleTodo.id + '" ' + checkinput + '>\
                            <label class="form-check-label" for="todo' + singleTodo.id + '">' + singleTodo.title + '</label>\
                        </div>\
                    </div>\
                </div>\
            </td>\
            <td> <p class="cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title=" '+ singleTodo.description + '">'+ singleTodo.description.slice(0, 30) + '...</p></td>\
            <td>' + singleTodo.dueDate + '</td>\
            <td>' + isStatus(singleTodo.status) + '</td>\
            <td>' + isPriority(singleTodo.priority) + '</td>\
            <td>\
            <div class="hstack gap-2">\
                <button class="btn btn-sm btn-soft-danger remove-list" data-bs-toggle="modal" data-bs-target="#removeTaskItemModal" data-remove-id='+ singleTodo.id + '><i class="ri-delete-bin-5-fill align-bottom"></i></button>\
                <button class="btn btn-sm btn-soft-info edit-list" data-bs-toggle="modal" data-bs-target="#createTask" data-edit-id='+ singleTodo.id + '><i class="ri-pencil-fill align-bottom"></i></button>\
            </div>\
            </td>\
        </tr>';

        editTodoList();
        removeSingleItem();
        checkTaskStatus();
        tooltipElm();
    });
}

// var isShowMenu = false;
// var todoMenuSidebar = document.getElementsByClassName('file-manager-sidebar');
// Array.from(document.querySelectorAll(".file-menu-btn")).forEach(function (item) {
//     item.addEventListener("click", function () {
//         Array.from(todoMenuSidebar).forEach(function (elm) {
//             elm.classList.add("menubar-show");
//             isShowMenu = true;
//         });
//     });
// });

// window.addEventListener('click', function (e) {
//     if (document.querySelector(".file-manager-sidebar").classList.contains('menubar-show')) {
//         if (!isShowMenu) {
//             document.querySelector(".file-manager-sidebar").classList.remove("menubar-show");
//         }
//         isShowMenu = false;
//     }
// });

function tooltipElm(){
    var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    var tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
}

function isStatus(val) {
    switch (val) {
        case "Pending":
            return ('<span class="badge bg-warning-subtle text-warning text-uppercase">' + window.translations.pending + "</span>");
        case "Inprogress":
            return ('<span class="badge bg-secondary-subtle text-secondary text-uppercase">' +window.translations.inprogress + "</span>");
        case "Completed":
            return ('<span class="badge bg-success-subtle text-success text-uppercase">' + window.translations.completed + "</span>");
        case "New":
            return ('<span class="badge bg-info-subtle text-info text-uppercase">' + window.translations.new + "</span>");
    }
}

function isPriority(val) {
    switch (val) {
        case "High":
            return ('<span class="badge bg-danger text-uppercase">' + window.translations.high + "</span>");
        case "Low":
            return ('<span class="badge bg-success text-uppercase">' + window.translations.low + "</span>");
        case "Medium":
            return ('<span class="badge bg-warning text-uppercase">' + window.translations.medium + "</span>");
    }
}

function checkTaskStatus() {
    Array.from(document.querySelectorAll("#task-list tr")).forEach(function (item) {
        item.querySelector(".form-check .form-check-input").addEventListener("change", function () {
            var getid = this.value;
            if (this.checked) {
                todoList = todoList.map(function (item) {
                    if (item.id == getid) {
                        item.checkedElem = true
                        item.status = "Completed"
                    }
                    return item;
                });
            } else {
                todoList = todoList.map(function (item) {
                    if (item.id == getid) {
                        item.checkedElem = false
                        item.status = "Inprogress"
                    }
                    return item;
                });
            }
            load(todoList)
        });
    });
}

function editTodoList() {
    var getEditid = 0;
    Array.from(document.querySelectorAll(".edit-list")).forEach(function (elem) {
        elem.addEventListener('click', function (event) {
            getEditid = elem.getAttribute('data-edit-id');
            todoList = todoList.map(function (item) {
                if (item.id == getEditid) {
                    editList = true;
                    document.getElementById("createTaskLabel").innerHTML = window.translations.editTask;
                    document.getElementById("addNewTodo").innerHTML = window.translations.save;
                    document.getElementById("taskid-input").value = item.id;
                    document.getElementById("task-title-input").value = item.title;
                    document.getElementById("task-description-input").value = item.description;

                    flatpickr(dateInput, {
                        dateFormat: "d M, Y",
                        defaultDate: new Date(item.dueDate)
                    });

                    var statusSelec = new DOMParser().parseFromString(item.status, "text/html").body;
                    statusVal.setChoiceByValue(statusSelec.innerHTML);
                    var prioritySelec = new DOMParser().parseFromString(item.priority, "text/html").body;
                    priorityVal.setChoiceByValue(prioritySelec.innerHTML);
                }
                return item;
            });
        });
    });
};

function removeSingleItem() {
    var getid = 0;
    Array.from(document.querySelectorAll(".remove-list")).forEach(function (item) {
        item.addEventListener('click', function (event) {
            getid = item.getAttribute('data-remove-id');
            document.getElementById("remove-todoitem").addEventListener("click", function () {

                $.ajax({
                    url: `/todo/${getid}`,
                    method: "DELETE",
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': tokenize
                    },
                    beforeSend: ()=>{
                        $('#remove-todoitem').html(`<div class="spinner-border text-light" style='width:1rem; height:1rem;' role="status" ><span class="sr-only">loading...</span></div>`)
                    },
                    success: (res) => {
                        function arrayRemove(arr, value) {
                            return arr.filter(function (ele) {
                                return ele.id != value;
                            });
                        }
                        var filtered = arrayRemove(todoList, getid);

                        todoList = filtered;

                        load(todoList);
                        document.getElementById("close-removetodomodal").click();
                        $('#remove-todoitem').html("")
                        $('#remove-todoitem').text(window.translations.yes)
                    },
                    error: (xhr, status, error) => console.log(error)
                })
            });
        });
    });
}


// choices category input
var taskStatusInput = new Choices(document.getElementById('choices-select-status'), {
    searchEnabled: false,
});

taskStatusInput.passedElement.element.addEventListener('change', function (event) {
    var taskStatusValue = event.detail.value;
    if (event.detail.value) {
        var filterData = todoList.filter(taskList => taskList.status == taskStatusValue);
        if (filterData.length == 0) {
            document.getElementById("noresult").style.display = "block";
            document.getElementById("todo-task").style.display = "none";
        } else {
            document.getElementById("noresult").style.display = "none";
            document.getElementById("todo-task").style.display = "block";
        }
    } else {
        var filterData = todoList;
    }
    load(filterData);
}, false);


// choices category input
var taskSortListInput = new Choices(document.getElementById('choices-select-sortlist'), {
    searchEnabled: false,
});

taskSortListInput.passedElement.element.addEventListener('change', function (event) {
    var taskSortListValue = event.detail.value;
    if (taskSortListValue == "By ID") {
        sortElementsById();
    } else if (taskSortListValue == "By Name") {
        sortElementsByName();
    } else {
        var filterData = todoList;
        load(filterData);
    }
}, false);


function load(manyTodos) {
    console.log("from load", manyTodos)
    loadList(manyTodos);
};

window.onload = function () {
    $('.todo-content').css('height', 'auto');
    sortElementsById('asc');
};

