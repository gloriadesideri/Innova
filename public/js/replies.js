let replies=document.getElementsByClassName('reply-container');
let comments=document.getElementsByClassName('comment-container');

for(let i=0; i<comments.length; i++) {
    let commentButton=document.getElementById('replies-'+comments[i].id)
    function displayReplies() {
        let container=document.getElementById('replies-box-'+comments[i].id);
        container.classList.remove('hidden');
        commentButton.removeEventListener('click',displayReplies);
        commentButton.addEventListener('click',hideReplies)
    }
    function hideReplies() {
        let container=document.getElementById('replies-box-'+comments[i].id);
        container.classList.add('hidden');
        commentButton.addEventListener('click',displayReplies);
        commentButton.removeEventListener('click',hideReplies)

    }
    commentButton.addEventListener('click',displayReplies)

}

for(let i=0; i<replies.length; i++){

    let button=document.getElementById('report-reply-'+replies[i].id)
    function displayReportForm() {
        let form=document.getElementById('report-form-reply-'+replies[i].id);
        form.classList.remove('hidden');
        button.removeEventListener('click',displayReportForm);
        button.addEventListener('click',hideReportForm)

    }
    function hideReportForm() {
        let form=document.getElementById('report-form-reply-'+replies[i].id);
        form.classList.add('hidden');
        button.removeEventListener('click',hideReportForm);
        button.addEventListener('click',displayReportForm)

    }

    if(button!=null){
        button.addEventListener('click',displayReportForm)
    }



}
