<%
for(var i=0; i<branches_list.length; i++){
 if(obj.branch == branches_list[i].id){
  var student_branch = branches_list[i].branch;
  break;
 }
}
for(var i=0; i<categories_list.length; i++){
 if(obj.category == categories_list[i].cat_id){
  var student_category = categories_list[i].category;
  break;
 }
}

var student_year = obj.year;
student_year = student_year;
%>


<%
/**
 * "student_year" is converted to a string and then processed
 * to get the last 2 digits of the year
 * eg : 12 instead of 2012
 */
%>

<tr data-student-id="<%= obj.student_id %>">
    <td><%= obj.student_id %></td>
    <td><%= obj.first_name %></td>
    <td><%= obj.last_name %></td>
    <td><%= obj.roll_num %>/<%= obj.branch %>/<%= student_year %></td>
    <td><%= obj.branch %></td>
    <td><%= obj.category %></td>
    <td>
        <a class="btn btn-success student-status" data-status="approved" data-table="blocked-table">UnBlock</a>
        <a class="btn btn-danger student-status" data-status="delete" data-table="blocked-table">Delete</a>
    </td>
</tr>
