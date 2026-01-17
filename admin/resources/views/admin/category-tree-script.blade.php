<script>
$(document).ready(function() {
    // 绑定展开/折叠按钮点击事件
    $(document).on('click', '.category-toggle-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var $btn = $(this);
        var categoryId = $btn.data('id');
        var $icon = $btn.find('i');
        var $row = $('#category-row-' + categoryId);
        
        if ($row.length > 0) {
            // 如果行已存在，切换显示/隐藏
            if ($row.is(':visible')) {
                // 收起：隐藏当前行及其所有子行
                $row.hide();
                $row.nextAll('.category-child-row[data-parent="' + categoryId + '"]').hide();
                $icon.removeClass('fa-caret-down').addClass('fa-caret-right');
            } else {
                // 展开：显示当前行
                $row.show();
                $icon.removeClass('fa-caret-right').addClass('fa-caret-down');
            }
        } else {
            // 如果行不存在，通过 AJAX 加载
            $icon.removeClass('fa-caret-right').addClass('fa-spinner fa-spin');
            
            $.ajax({
                url: '{{ admin_url("game-categories/children") }}',
                type: 'GET',
                data: { parent_id: categoryId },
                success: function(html) {
                    $icon.removeClass('fa-spinner fa-spin').addClass('fa-caret-down');
                    
                    // 找到父分类所在的行
                    var $parentRow = $btn.closest('tr');
                    if ($parentRow.length === 0) {
                        $parentRow = $btn.closest('tbody').find('tr').first();
                    }
                    
                    // 在父分类行后插入子分类行
                    $parentRow.after(html);
                },
                error: function() {
                    $icon.removeClass('fa-spinner fa-spin').addClass('fa-caret-right');
                    alert('加载子分类失败');
                }
            });
        }
    });
});
</script>
