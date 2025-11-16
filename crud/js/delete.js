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

//auto delete groups after a week
function auto_delete_groups() {
   $.get("../../crud/php/auto_delete_groups.php", function (response) {
      return;
   })
}


function leave_group(member_id) {
   if (!confirm("Do you wish to leave the group?")) {
      return;
   } else {
      $.post("../../crud/php/leave_group.php", { member_id: member_id }, function (response) {
         if (response === "leave") {
            window.location.href = "view_group.php";
         }
      });
   }
}


$(document).on('click', '.decline-request', function () {
   let member_id = $(this).data("member-id");

   $.post("../../crud/php/decline_request.php", { member_id: member_id }, function (decline_response) {
      alert(decline_response)
      if (decline_response === "accepted request") {
         let modal_decline = new bootstrap.Modal(document.getElementById('request_declined'));
         modal_decline.show();
         load_all_notifications();
      }
   });
})