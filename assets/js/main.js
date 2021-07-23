function validateActivity(form){
  msgError="";
  if(form.nameActivity.value==""){
      $msgError="Preencha o campo nome";
  }else if(form.descriptionActivity.value==""){
      $msgError="Preencha o campo descrição";
  }else if(form.deadlineActivity.value==""){
      $msgError="Preencha o campo prazo";
  }else if(form.xpActivity.value==""){
      $msgError="Preencha o campo de experiência";
  }else{
      return true;
  }
  $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+ $msgError +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
  $("#msgErrorJs").html($alert);
  return false;
}

function validateGroup(form){
  msgError="";
  if(form.nameGroup.value==""){
      $msgError="Preencha o campo nome";
  }else if(form.descriptionGroup.value==""){
      $msgError="Preencha o campo descrição";
  }else if (form.interestsGroup.value==""){
      $msgError="Escolha um tipo de conteúdo";
  }else{
      return true;
  }
  $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+ $msgError +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
  $(".msgErrorJs").html($alert);
  return false;
}

function validateFormInvite(form){
    msgErrorInvite="";
    if(form.inviteFriendSelect.value=""){
        $msgErrorInvite="Selecione um grupo";
    }
    else{
        return true;
    }
    $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+ $msgErrorInvite +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    $("#msgErrorInvite").html($alert);
    return false;
}
function clear(){
    $(".msgErrorJs").html("");
}

$('a[href$="#addFriendModal"]').on( "click", function() {
    $('#addFriendModal').modal('show');
});

function closeSearchFriends(btn){
    $(btn).remove();
    $('#searchFriends').remove();
}

function closeSearchGroups(btn){
    $(btn).remove();
    $('#searchGroups').remove();
}

$(function(){
    $('#groupAlterModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id          = button.data('id');
        var nome        = button.data('nome');
        var descricao   = button.data('descricao');
        var tipo        = button.data('tipo');
        var link        = "main.php?folder=system/groups/&file=del_groups.php&id="+id;
        var modal = $(this);
        modal.find('.modal-body input[name=idGroup]').val(id);
        modal.find('.modal-body input[name=nameGroup]').val(nome);
        modal.find('.modal-body input[name=descriptionGroup]').val(descricao);
        modal.find('.modal-body select[name=interestsGroup]').val(tipo);
        modal.find('#linkDesativar').attr('href', link);
    })
})

$(function(){
    $('#alterActivityModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id          = button.data('id');
        var nome        = button.data('nome');
        var descricao   = button.data('descricao');
        var prazo       = button.data('prazo');
        var experiencia = button.data('experiencia');
        var link        = "main.php?folder=system/activities/&file=del_activities.php&id="+id;
        var modal = $(this);
        modal.find('.modal-body input[name=idActivity]').val(id);
        modal.find('.modal-body input[name=nameActivity]').val(nome);
        modal.find('.modal-body input[name=descriptionActivity]').val(descricao);
        modal.find('.modal-body input[name=deadlineActivity]').val(prazo);
        modal.find('.modal-body select[name=xpActivity]').val(experiencia);
        modal.find('#linkDesativar').attr('href', link);
    })
})

$(function(){
    $('#alterActivityGroup').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var idgroup     = button.data('idgroup');
        var id          = button.data('id');
        var nome        = button.data('nome');
        var descricao   = button.data('descricao');
        var prazo       = button.data('prazo');
        var experiencia = button.data('experiencia');
        var link        = "main.php?folder=system/activities/&file=del_activities.php&id="+id+"&idGroup="+idgroup;
        var modal = $(this);
        modal.find('.modal-body input[name=idGroup]').val(idgroup);
        modal.find('.modal-body input[name=idActivity]').val(id);
        modal.find('.modal-body input[name=nameActivity]').val(nome);
        modal.find('.modal-body input[name=descriptionActivity]').val(descricao);
        modal.find('.modal-body input[name=deadlineActivity]').val(prazo);
        modal.find('.modal-body select[name=xpActivity]').val(experiencia);
        modal.find('#linkDesativar').attr('href', link);
    })
})

$(function(){
    $('#inviteFriendModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id     = button.data('id');
        var modal = $(this);
        modal.find('.modal-body input[name=idUserFriend]').val(id);              
    })
})

$(function(){
    $('#delFriendModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id     = button.data('id');
        var modal = $(this);
        modal.find('.modal-body input[name=idUserDelFriend]').val(id);              
    })
})