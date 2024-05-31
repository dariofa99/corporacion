export class AppService {
    getQuestionValues(obj) {
        let data = {};
        if ((($(obj).attr("data-type") == 58
            || $(obj).attr("data-type") == 136) && $(obj).is(":checked"))
            || (($(obj).attr("data-type") != 58 && $(obj).attr("data-type") != 136) && $(obj).val() != '')) {
            data = {
                value: $(obj).attr("data-option") != undefined ? $(obj).val() : $(obj).find(":selected").text(),
                section: $(obj).attr("data-section"),
                type: $(obj).attr("data-type"),
                name: $(obj).attr("data-name"),
                question_id: $(obj).attr("data-reference_id"),
                option_id: $(obj).attr("data-option") != undefined ? $(obj).attr("data-option") : $(obj).val(),
                value_is_other: $("#value_other_text-" + $(obj).attr("data-reference_id")).val(),
            };
        } else {
            data = {
                value: "",
                section: $(obj).attr("data-section"),
                type: $(obj).attr("data-type"),
                name: $(obj).attr("data-name"),
                question_id: $(obj).attr("data-reference_id"),
                option_id: $(obj).attr("data-option") != undefined ? $(obj).attr("data-option") : $(obj).val(),
                value_is_other: "",
            };
        }
        return data;
    }

    getAditionalQuestion(obj) {
        let data = this.getQuestionValues(obj);
        return {
            'user_id': $("#user_id").val(),
            'component': 'case',
            "data": [{
                "question_id": data.question_id,
                "options": [
                    {
                        option_id: data.option_id,
                        value: data.value,
                        value_is_other:data.value_is_other
                    }
                ]
            }]
        }
    }

}