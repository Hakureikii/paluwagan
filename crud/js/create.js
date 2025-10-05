// Form Group Function
function form_group(group_name, capacity) {
   $.post("../../crud/php/form_group.php",
      {
         group_name: group_name,
         capacity: capacity
      },
      function (response) {
         alert(response);
      })
}