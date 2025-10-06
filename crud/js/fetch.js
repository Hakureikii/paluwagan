function display_group_members() {
   $.get("../../crud/php/fetch_group_members.php", function (response) {
      let members = JSON.parse(response);
      let display ="";

      for (let i = 0; i < members.length; i++) {
         display +=
            `<tr>
            <td> ${i + 1} </td>
            <td> ${members[i].name} </td>
         </tr>`
      }
      $("#group_members_table").html(display);
   })
}


function display_pending_invites() {
   $.get("../../crud/php/fetch_pending_invites.php", function (response) {
      let pending = JSON.parse(response);
      let display = ""

      for (let i = 0; i < pending.length; i++) {
         display +=
            `<tr>
            <td> ${i + 1} </td>
            <td> ${pending[i].group_name} </td>
            <td> ${pending[i].sender} </td>
            <td> ${pending[i].reciever} </td>
            <td> ${"Pending"} </td>
         </tr>`
      }
      $("#pending_invites_table").html(display);
   })
}


function display_group_name() {
   $.get("../../crud/php/fetch_group_name.php", function (response) {
      if (response === "no group") {
         $("#invite_members").prop("disabled", true);
         $("#leave_group").prop("disabled", true);
         $(".pending_invites_table").hide();
         $("#group_name").html("Wala ka pa group bai");
      } else {
         let group = JSON.parse(response);
         $("#invite_members").prop("disabled", false);
         $("#leave_group").prop("disabled", false);
         $(".pending_invites_table").show()
         $("#group_name").html("Group: " + group);
      }
   })
}


function display_group_invitations() {
   $.get("../../crud/php/fetch_group_invitations.php", function (response) {
      let invitations = JSON.parse(response);
      let display = "";

      for (let i = 0; i < invitations.length; i++) {
         display +=
            `<tr>
            <td> ${i + 1} </td>
            <td> ${invitations[i].group_name} </td>
            <td> ${invitations[i].sender} </td>
            <td> ${invitations[i].reciever} </td>
            <td> 
            <button type="button" data-id="${invitations[i].group_id}" id="accept_invitation"> Accept </button> 
            <button type="button" data-id="${invitations[i].group_id}" id="decline_invitation"> Decline </button> 
            
            </td>
         </tr>`
      }
      $("#group_invitations").html(display);
   })
}