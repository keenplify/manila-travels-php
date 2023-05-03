const resultRows = document.querySelectorAll("tr");
const editBtns = document.querySelectorAll(".edit-button");
const deleteBtns = document.querySelectorAll(".delete-button");
const table = document.querySelector("table");

resultRows.forEach(row => 
    row.addEventListener("click", editOrDelete)  
);

if(table)
{
    table.addEventListener("click", collapseForm);
}

function collapseForm(evt){
    if(evt.target.className.includes("btn-close")){
        const collapseRow = evt.target.parentElement.parentElement.parentElement.parentElement;

        // enable the edit button
        const editBtn = collapseRow.previousElementSibling.children[2].children[0];
        editBtn.disabled = false;
        editBtn.classList.remove("disabled");

        // Collapse the row
        collapseRow.remove();
    }
}

function handleEditSubmit(evt) {
    console.log(evt)
}

function editOrDelete(evt){
    
    if(evt.target.className.includes("edit-button"))
    {
        // Disable the button
        evt.target.disabled = true;
        evt.target.classList.add("disabled");

        const editRow = document.createElement("tr");
        editRow.innerHTML = `
        <td colspan="4">
            <form class="editRouteForm d-flex justify-content-between w-100" method="POST">
                <input type="hidden" name="id" value="${evt.target.dataset.id}">
                <input type="text" class="form-control flex-grow-1" name="busno" value="${evt.target.dataset.busno}">
                <select class="form-select" name="status" value="${evt.target.dataset.status}">
                    <option>Active</option>
                    <option>In Maintenance</option>
                </select>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success btn-sm" name="edit">SUBMIT</button>
                </div>
            </form>
        </td>
    `;
    
    this.after(editRow);
    }

    // if delete button is clicked
    else if(evt.target.className.includes("delete-button"))
    {
        const deleteInput = document.querySelector("#delete-id");
        deleteInput.value = evt.target.dataset.id;
    }
}

// Add Bus Form validation
const addBusForm = document.querySelector("#addBusForm");

addBusForm.addEventListener("submit", validateForm);

function validateForm(evt)
{
    const busnoInput = addBusForm.elements.busnumber;
    const regex = new RegExp("[a-z]+", "g");
    const errorSpan = document.querySelector("#error");

    if(busnoInput.value.match(regex))
    {
        evt.preventDefault();
        errorSpan.innerText = "Bus Number should have capital letters";
    }
}

