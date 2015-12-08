/* To initialize BS3 tooltips set this below */
$(document).on('ready pjax:success', function(){
    $("[data-toggle='tooltip']").tooltip();
});
/* To initialize BS3 popovers set this below */
$(document).on('ready pjax:success', function(){
    $("[data-toggle='popover']").popover();
});
