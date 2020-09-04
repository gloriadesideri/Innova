let solutions=document.getElementsByClassName('solution-container');

for(let i=0; i<solutions.length; i++){

    let button=document.getElementById('report-solution-'+solutions[i].id)

    let commentButton=document.getElementById('comments-'+solutions[i].id)
    function displayReportForm() {
        let form=document.getElementById('report-form-solution-'+solutions[i].id);
        form.classList.remove('hidden');
        button.removeEventListener('click',displayReportForm);
        button.addEventListener('click',hideReportForm)

    }
    function hideReportForm() {
        let form=document.getElementById('report-form-solution-'+solutions[i].id);
        form.classList.add('hidden');
        button.removeEventListener('click',hideReportForm);
        button.addEventListener('click',displayReportForm)

    }
    function displayComments() {
        let container=document.getElementById('comment-box-'+solutions[i].id);
        container.classList.remove('hidden');
        commentButton.removeEventListener('click',displayComments);
        commentButton.addEventListener('click',hideComments)
    }
    function hideComments() {
        let container=document.getElementById('comment-box-'+solutions[i].id);
        container.classList.add('hidden');
        commentButton.addEventListener('click',displayComments);
        commentButton.removeEventListener('click',hideComments)

    }
    if(button!=null){
        button.addEventListener('click',displayReportForm)
    }
    commentButton.addEventListener('click',displayComments)



}
