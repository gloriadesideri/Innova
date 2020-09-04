let input=document.getElementById('tag-input');
let output=document.getElementById('tag-output');
let tagValue=document.getElementById('tag-value')
let log=''
let value=''
let posts=document.getElementsByClassName('post-container');


input.addEventListener('keypress', function (e){
    if(e.keyCode === 32){
        updateValue(e)
    }
});

for(let i=0; i<posts.length; i++){

    let button=document.getElementById('report-'+posts[i].id)
    let commentButton=document.getElementById('comments-'+posts[i].id)
    function displayReportForm() {
        let form=document.getElementById('report-form-'+posts[i].id);
        form.classList.remove('hidden');
        button.removeEventListener('click',displayReportForm);
        button.addEventListener('click',hideReportForm)

    }
    function hideReportForm() {
        let form=document.getElementById('report-form-'+posts[i].id);
        form.classList.add('hidden');
        button.removeEventListener('click',hideReportForm);
        button.addEventListener('click',displayReportForm)

    }
    function displayComments() {
        let container=document.getElementById('comment-box-'+posts[i].id);
        container.classList.remove('hidden');
        commentButton.removeEventListener('click',displayComments);
        commentButton.addEventListener('click',hideComments)
    }
    function hideComments() {
        let container=document.getElementById('comment-box-'+posts[i].id);
        container.classList.add('hidden');
        commentButton.addEventListener('click',displayComments);
        commentButton.removeEventListener('click',hideComments)

    }
    if(button!=null){
        button.addEventListener('click',displayReportForm)
    }
    commentButton.addEventListener('click',displayComments)



}

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
    input.value=''

    console.log(tagValue.value)

}

