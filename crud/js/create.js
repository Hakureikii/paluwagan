// Form Group Function
function form_group(group_name, capacity) {

   if (capacity > 5 && capacity < 9) {
      $.post("../../crud/php/form_group.php",
         {
            group_name: group_name,
            capacity: capacity
         },
         function (response) {
            if (response === "err") {
               alert("Fields should be filled up!")
            } else if (response ==="You are currently on a group!") {
               alert(response);
            } else {
               window.location.href="../../templates/members/view_group.php";
            }
         })
   } else {
      let message = document.getElementById("error-message");
      message.innerHTML = `<p> Group capacity should be a minimum of 6 members and a max of 8 members </p>`;
      $("#error-message").fadeOut(3000);
   }

}

function send_member_invites(selected_members) {
   $.post("../../crud/php/send_member_invites.php", {members: selected_members}, function(response) {
      alert(response);
      display_pending_invites();
   })
}