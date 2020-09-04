let comments=document.getElementsByClassName('comment-container');
for(let i=0; i<comments.length; i++){

    let button=document.getElementById('report-comment-'+comments[i].id)
    function displayReportForm() {
        let form=document.getElementById('report-form-comment-'+comments[i].id);
        form.classList.remove('hidden');
        button.removeEventListener('click',displayReportForm);
        button.addEventListener('click',hideReportForm)

    }
    function hideReportForm() {
        let form=document.getElementById('report-form-comment-'+comments[i].id);
        form.classList.add('hidden');
        button.removeEventListener('click',hideReportForm);
        button.addEventListener('click',displayReportForm)

    }

    if(button!=null){
        button.addEventListener('click',displayReportForm)
    }



}
