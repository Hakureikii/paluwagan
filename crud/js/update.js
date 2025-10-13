//Accept invitation
$(document).on('click', '.accept-invitation', function () {
   let group_id = $(this).data("id");
   if (!confirm("Accept Invitation?")) {
      return;
   } else {
      $.post("../../crud/php/accept_invitations.php",
         {
            group_id: group_id
         },
         function (response) {
            alert(response);
            display_group_invitations();
         })
   }
})