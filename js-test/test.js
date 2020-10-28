const rusData = require('./rus-data.js');
const ukData = require('./urk-data.js');
const options = {
    "echo-result": true
};
const Translate = require('./Translate.js');
const translator = new Translate(options);

translator
    .setLang('uk')
    .addTranslation(ukData, 'uk')
    .addTranslation(rusData, 'ru');
    
translator.translate('Привет'); // Привіт
translator.translate('Привет %s', 'user'); // Привіт user
translator.translate(['%s день', '%s дня', '%s дней', 10]) // 10 днів
translator.translate(['%s день', '%s дня', '%s дней', 1]) // 1 день
translator.translate(['%s день', '%s дня', '%s дней', 3]) // 3 дні
translator.setLang('ru');
translator.translate('Привет'); // Привет
translator.translate('Привет %s', 'user'); // Привет user
translator.translate(['%s день', '%s дня', '%s дней', 10]) // 10 дней
translator.translate(['%s день', '%s дня', '%s дней', 1]) // 1 день
translator.translate(['%s день', '%s дня', '%s дней', 3]) // 3 дня