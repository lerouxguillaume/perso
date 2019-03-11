import Vue from 'vue'

var truncate = function(text, length, clamp, soft){
    clamp = clamp || '...';
    soft = soft || false;

    var node = document.createElement('div');
    node.innerHTML = text;
    var content = node.textContent;

    if (soft) {
        while (content[length] !== ' ' && length  > 0) {
            length--;
        }
    }

    return content.length > length ? content.slice(0, length) + clamp : content;
};

var formatFloat = function (number, size) {
    if (typeof number != "number") {
        return 'NA';
    }
    return number.toFixed(size);
};



Vue.filter('truncate', truncate);
Vue.filter('formatFloat', formatFloat);
