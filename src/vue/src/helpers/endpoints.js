let apiBase = '';

if (process.env.NODE_ENV === 'development') {
    apiBase = 'http://elab.loc/demo-1';
}

export const endpoints = {
    data: function () {
        return {
            apiEndpoints: {
                'content': apiBase + '/wp-json/x_builder/v1/content/701',
                'save_content': apiBase + '/wp-json/x_builder/v1/save_content/701',
                'elements': apiBase + '/wp-json/x_builder/v1/elements',
                'upload_image': apiBase + '/wp-json/x_builder/v1/upload_image',
                'get_image': apiBase + '/wp-json/x_builder/v1/get_image',
                'export_page': apiBase + '/wp-admin/admin-ajax.php?action=export_page&page=1952',
                'import_page': apiBase + '/wp-admin/admin-ajax.php?action=import_page&page=1952',
            }
        }
    },
    created: function () {
        let _this = this;
        if (typeof x_builder_endpoints !== 'undefined') {
            _this.$set(_this, 'apiEndpoints', x_builder_endpoints);
        }
    }
};