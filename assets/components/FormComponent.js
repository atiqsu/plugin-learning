import React from "react";
const {useState} = React;

const FormComponent = () =>{
    const [formData, setFormData] = useState({
        name: '',
        username: '',
        email: '',
        message: ''
    });

    const handleChange = (field) => (e) => {
        setFormData({...formData, [field]: e.target.value });
    }

    const handleSubmit = (e) =>{
        e.preventDefault();
        // console.log('Subitted: ', formData);
        
        fetch(`${myPluginData.rest_url}my-plugin/v1/submit-form`, {
            method: 'POST',
            headers: {
                'Content-Type' : 'application/json',
                'X-WP-Nonce' : myPluginData.nonce
            },
            body: JSON.stringify(formData),
        })
        .then((res) => res.json())
        .then((data) => {
            console.log('API Response:', data.message);
        })
        .catch((error) => {
            console.log('Error:', error);
        })
    };

    const renderInput = (label, field, type = 'text') => {
        return React.createElement(
            React.Fragment,
            {key: `${field}-wrapper`},
            [
                React.createElement('div', { className: 'form-group', key: `${field}-group` }, [
                    React.createElement('label', {htmlFor: field, key: `${field}-label`}, label),
                    React.createElement('input', {
                        key: `${field}-input`,
                        type,
                        id: field,
                        value: formData[field],
                        onChange: handleChange(field),
                        className: 'form-control',
                    }),
                ]),
            ]
        );
    };

    const rederTextArea = (label, field) => {
        return React.createElement(
            React.Fragment,
            {key: `${field}-wrapper`},
            [
                React.createElement('div', {className: 'form-group', key: `${field}-group`}, [
                    React.createElement('label', { htmlFor: field, key: `${field}-label` }, label),
                    React.createElement('textarea', {
                        key: `${field}-textarea`,
                        id: field,
                        value: formData[field],
                        onChange: handleChange(field),
                        className: 'form-control',
                        rows: 4,
                    }),
                ]),
            ]
        );
    };

    return React.createElement(
        'form',
        {onSubmit: handleSubmit},
        [
            renderInput('Name', 'name'),
            renderInput('Username', 'username'),
            renderInput('Email', 'email'),
            rederTextArea('Message', 'message'),
            React.createElement(
                'button', 
                {type: 'submit', className: 'submit-button', key: 'submit-button'},
                'Submit'
            ),
        ]
    );
};
export default FormComponent;

