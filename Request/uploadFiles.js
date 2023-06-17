let fileInput = document.getElementById("file-input");
let fileList = document.getElementById("files-list");
let numOfFiles = document.getElementById("num-of-files");

fileInput.addEventListener("change", () => {
    fileList.innerHTML = "";
    numOfFiles.textContent = `${fileInput.files.length} Files Selected`;
    

    for(i of fileInput.files){
        let reader = new FileReader();
        let listItem = document.createElement("li");
        let fileName = i.name;
        listItem.innerHTML = `<p>${fileName}</p><input type="button" id ="Remove" value="Remove" onclick="removeFile(this)" />`; 
        fileList.appendChild(listItem);
    }
});

function removeFile(button) {
    let listItem = button.parentNode;
    fileList.removeChild(listItem);

    // Update the numOfFiles count
    let currentCount = parseInt(numOfFiles.textContent);
    numOfFiles.textContent = `${currentCount - 1} Files Selected`;

    // Remove the file from the fileInput.files array
    let fileName = listItem.querySelector("p").textContent;
    let newFileList = Array.from(fileInput.files).filter(file => file.name !== fileName);
    fileInput.files = new FileList(...newFileList);
}






