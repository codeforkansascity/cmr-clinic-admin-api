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
        getBoolean(value) {

            if ( typeof value == "string") {
                value = value.toLowerCase();
            }
            switch (value) {
                case true:
                case "true":
                case 1:
                case "1":
                case "on":
                case "yes":
                    return true;
                default:
                    return false;
            }
        },
        scrollToTop() {
            document.querySelector('body').scrollIntoView({behavior:'smooth'});
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
