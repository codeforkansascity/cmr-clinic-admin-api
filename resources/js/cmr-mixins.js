// Custom js

Vue.mixin({
    methods: {
        isDefined (obj) {
            return ((typeof obj !== 'undefined') && (obj !== null));
        },
        formatNumber (value, precision) {
            return (parseFloat(value).toFixed(precision || 0)
                .replace(/\B(?=(\d{3})+(?!\d))/g, ','));
        },
        isUndefinedOrEmpty (obj) {
            return ((typeof obj === 'undefined') || (obj === null)
                || ((typeof obj === 'string') && (!obj.trim())));
        },
    }
});

Vue.directive('tooltip', function(el, binding){
    jQuery(el).on('click', function(e){ e.preventDefault() });
    jQuery(el).tooltip({
        title: jQuery('.help-text', el).html(),
        html: true,
        placement: 'top',
        trigger: 'hover focus'
    });
});
