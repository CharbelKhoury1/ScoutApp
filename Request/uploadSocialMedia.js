let fInput = document.getElementById("f-input");
let fList = document.getElementById("f-list");
let numFiles = document.getElementById("num-files");

fInput.addEventListener("change", () => {
    fList.innerHTML = "";
    numFiles.textContent = `${fInput.files.length} Files Selected`;
    

    for(i of fInput.files){
        let read = new FileReader();
        let lItem = document.createElement("li");
        let fName = i.name;
        lItem.innerHTML = `<p>${fName}</p><input type="button" id ="Remove" value="Remove" onclick="remove(this)" />`; 
        fList.appendChild(lItem);
    }
});

function remove(button) {
    let lItem = button.parentNode;
    fList.removeChild(lItem);

    // Update the numOfFiles count
    let currentCount = parseInt(numFiles.textContent);
    numFiles.textContent = `${currentCount - 1} Files Selected`;

    // Remove the file from the fileInput.files array
    let fName = lItem.querySelector("p").textContent;
    let newFList = Array.from(fInput.files).filter(file => file.name !== fName);
    fInput.files = new FileList(...newFList);
}






