let input=document.getElementById('tag-input');
let output=document.getElementById('tag-output');
let tagValue=document.getElementById('tag-value')
let log=''
let value=''

input.addEventListener('keypress', function (e){
    if(e.keyCode === 32){
        updateValue(e)
    }
});

function updateValue(e) {
    log= e.target.value;
    value+=e.target.value+',';

    let badge=document.createElement('span')
    badge.innerText=log
    badge.classList.add("ml-2", "text-grey-500", "text-xs",  "font-semibold", "tracking-wide",'bg:grey-100', 'p-2','hover:bg-red-100','cursor-pointer','rounded')
    badge.nodeValue=log
    badge.addEventListener('click',function () {
        value=value.replace(badge.innerText+',',"")
        badge.parentElement.removeChild(badge);
        tagValue.value=value



    })
    output.appendChild(badge)
    tagValue.value=value
    tagValue.innerHTML=""
    input.value=""

    console.log(tagValue.value)

}
