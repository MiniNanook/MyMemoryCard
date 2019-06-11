function setPreview() {
    //Getting Value

            let img = new Image();
            let div = document

    var selObj = document.getElementById("cover_image");
    var selValue = selObj.options[selObj.selectedIndex].text;
    
    //Setting Value
    document.getElementById("platform").value = selValue;
}
var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
};