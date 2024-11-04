const inputs = document.querySelectorAll("input");
      button = document.querySelector("button");

inputs.forEach((input, index1) => {
    input.addEventListener("keyup", (e) => {
        const currentInput = input;
        nextInput = input.nextElementSibling;
        prevInput = input.previousElementSibling;
        if(currentInput.value.length > 1){
            currentInput.value = "";
            return;
        }
        if(nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== ""){
            nextInput.removeAttribute("disabled");
            nextInput.focus();
        }
        if(e.key === "Backspace"){
            if(index1 <= index2 && prevInput){
                input.setAttribute("disabled", true);
                input.value = "";
                prevInput.focus();
            }
        }
        if(!inputs[4].disabled && inputs[3].value !== ""){
            button.classlist.add('active');
            return;
        }   
        button.classlist.remove('active');
    });
});
window.addEventListener("load", () => inputs[0].focus());