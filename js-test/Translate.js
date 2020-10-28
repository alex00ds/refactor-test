function handleError(message) {
    throw {message: message}
}

const pluralKeys = [2, 0, 1, 1, 1, 2];

function plural(num){
   return num % 100 > 4 && num % 100 < 20 ? 2 : pluralKeys[Math.min(num % 10, 5)];
}

module.exports = class Translate {

    constructor(options) {
        this.options = options;
        this.lang = '';
        this.translations = {};
    }    

    /**
     *
     * @param {Object} data
     * @param {String} lang
     * @returns {Translate}
     */
    addTranslation(data, lang) {
        // todo check args
        if (typeof(data) != 'object') {
            handleError("Wrong translation data");
        }
        if (typeof(lang) != 'string') {
            handleError("Wrong translation language");
        }
        this.translations[lang] = data;
        return this;
    }
    
    /**
     * Examples
     *
     * translate(['%s день', '%s дня', '%s дней', 10]) // множественная форма
     * translate('Привет')
     * translate('Привет %s', 'гость')
     *
     * @param {String|Number|Array} msgId
     * @returns {String|Translate}
     */
    translate(msgId) {
        const langTrans = this.translations[this.lang];
        if (! langTrans) {
            handleError(`Translations for "${this.lang}" language not found`);
        }
        
        var substitution = '';

        if (typeof(msgId) == 'object') {
            if (typeof(msgId.pop) != 'function') {
                handleError("Wrong translation argument");
            }

            if (msgId.length < 4) {
                handleError("Wrong count of translation arguments");
            }

            substitution = msgId.pop();
            msgId = msgId[plural(substitution)];
        }
        else {
            if (arguments.length > 1) {
                substitution = arguments[1];
            }
        }
        
        var translation = langTrans[msgId];

        if (! translation) {
            //handleError(`Translation for "${msgId}" not found`);
            translation = msgId;
        }
        
        const result = translation.split('%s').join(substitution);
        
        if (this.options['echo-result']) {
            console.log(result);
        }
        return result;
    }
    
    /**
     * Current locale
     *
     * @param {string} lang
     * @returns {Translate}
     */
    setLang(lang) {
        if (typeof(lang) != 'string') {
            handleError("Wrong translation language");
        }
        this.lang = lang;
        return this;
    }
    /**
     *
     * @returns {string}
     */
    getLang() {
        return this.lang;
    }
   
}