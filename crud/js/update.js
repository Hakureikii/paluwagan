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
            load_all_notifications();
         })
   }
})


$(document).on('click', '.notifications-link', function() {
   $.post("../../crud/php/read_notifications.php", {is_read: 1}, function(response) {

   });
})