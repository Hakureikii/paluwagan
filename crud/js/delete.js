//Decline invitation
$(document).on('click', '.decline-invitation', function () {
   let group_id = $(this).data("id");
   if (!confirm("Decline invitation?")) {
      return;
   } else {
      $.post("../../crud/php/decline_invitations.php",
         {
            group_id: group_id
         },
         function (response) {
            alert(response);
            display_group_invitations();
         })
   }

})