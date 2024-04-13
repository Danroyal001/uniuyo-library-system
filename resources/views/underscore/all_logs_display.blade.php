<tr>
    <td><%= obj.id %></td>
    <td><%= obj.book_issue_id %></td>
    <td><%= obj.book_name %></td>
    <td><%= obj.student_name %></td>
    <td><%= obj.issued_at %></td>
    <td><%= obj.returnDate %></td>
    <% if (obj.status === 'lost') { %>
    <td>$<%= obj.fin %></td>
    <% } %>
    <% if (obj.status === 'issued') { %>
    <td>
        <div class="btn-group">
            <a class="btn btn-info" onclick="handleReturnBookClick(this)" data-studentid="<%= obj.student_id %>"
                data-bookid="<%= obj.id %>" data-status="returned">Return</a>
            <a class="btn btn-danger" onclick="handleReturnBookClick(this)" data-studentid="<%= obj.student_id %>"
                data-bookid="<%= obj.id %>" data-status="lost">Maek as Lost</a>
        </div>
    </td>
    <% } %>
</tr>
