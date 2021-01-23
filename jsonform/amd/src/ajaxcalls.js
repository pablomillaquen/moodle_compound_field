import $ from "jquery";
import { exception } from "core/notification";
import ajax from "core/ajax";
import { JSONEditor } from "local_jsonform/jsoneditor";

var editor;
const loadform = (userid, fieldid)=>{
    const promisesLoad = ajax.call([{
        methodname: "local_jsonform_loadjson",
        args: {userid, fieldid},
        fail: exception
    }]);
    promisesLoad[0].then(data => {
        if(data.length > 0){
            $('#data').val(data[0].data);
            let actualData = JSON.parse(data[0].data);
            JSONEditor.setValue(actualData);
        }else{
            return Error;
        }
        return(data.length > 0 ? data[0].data : "No data");
        window.console.log(data);
    });
};

const updateform = (userid, fieldid, data, dataformat, type)=>{
    const promisesUpdate = ajax.call([{
        methodname: "local_jsonform_updatejson",
        args: {data:data, userid:userid, fieldid:fieldid, dataformat:dataformat, type:type},
        fail: exception
    }]);
    promisesUpdate[0].then(data => {
        window.console.log(data);
        window.location.replace("/user/profile.php?id="+userid);
    });
};

const getform = (userid, fieldid)=>{

    const promises = ajax.call([{
        methodname: "local_jsonform_getform",
        args: {fieldid:fieldid},
        fail: exception
    }]);

    const promisesLoad = ajax.call([{
        methodname: "local_jsonform_loadjson",
        args: {userid, fieldid},
        fail: exception
    }]);

    promises[0].then(data => {
        const element = document.getElementById('editor_holder');
        editor = new JSONEditor(element, {
            schema:JSON.parse(data[0].param1),
            theme: 'bootstrap4',
            iconlib: "fontawesome4",
            disable_edit_json:true,
            disable_properties:true,
            disable_collapse:true,
            prompt_before_delete: false,
            template: 'mustache'
        });
    }).then(()=>{
        return promisesLoad[0];
    }).then(data=>{
        if(data[0].data){
            editor.setValue(JSON.parse(data[0].data));
            $('#data').val(data[0].data);
        }
    }).catch(window.console.log.bind(console));
};

export { loadform, updateform, getform, editor };