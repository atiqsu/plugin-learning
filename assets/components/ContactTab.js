import React from "react";
const {useState} = React;

const ContactTab = () =>{
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

    // const renderInput = (label, field, type = 'text') => {
    //     return React.createElement(
    //         React.Fragment,
    //         {key: `${field}-wrapper`},
    //         [
    //             React.createElement('div', { className: 'form-group', key: `${field}-group` }, [
    //                 React.createElement('label', {htmlFor: field, key: `${field}-label`}, label),
    //                 React.createElement('input', {
    //                     key: `${field}-input`,
    //                     type,
    //                     id: field,
    //                     value: formData[field],
    //                     onChange: handleChange(field),
    //                     className: 'form-control',
    //                 }),
    //             ]),
    //         ]
    //     );
    // };

    // const rederTextArea = (label, field) => {
    //     return React.createElement(
    //         React.Fragment,
    //         {key: `${field}-wrapper`},
    //         [
    //             React.createElement('div', {className: 'form-group', key: `${field}-group`}, [
    //                 React.createElement('label', { htmlFor: field, key: `${field}-label` }, label),
    //                 React.createElement('textarea', {
    //                     key: `${field}-textarea`,
    //                     id: field,
    //                     value: formData[field],
    //                     onChange: handleChange(field),
    //                     className: 'form-control',
    //                     rows: 4,
    //                 }),
    //             ]),
    //         ]
    //     );
    // };

    // return React.createElement(
        // 'form',
        // {onSubmit: handleSubmit},
        // [
        //     renderInput('Name', 'name'),
        //     renderInput('Username', 'username'),
        //     renderInput('Email', 'email'),
        //     rederTextArea('Message', 'message'),
        //     React.createElement(
        //         'button', 
        //         {type: 'submit', className: 'submit-button', key: 'submit-button'},
        //         'Submit'
        //     ),
        // ]
    // );

    return (
        <form className="contact-form">
            <div className="contact-wrapper">
                <div className="input-field">
                    <div className="form-group">
                        <label>Name</label>
                        <input type="text" value={formData.name} placeholder="Enter your name..." onChange={handleChange('name')} />
                    </div>
                    <div className="form-group">
                        <label>Username</label>
                        <input type="text" value={formData.username} placeholder="Username..." onChange={handleChange('username')} />
                    </div>
                    <div className="form-group">
                        <label>Email</label>
                        <input type="email" value={formData.email} placeholder="Enter your email..." onChange={handleChange('email')} />
                    </div>
                </div>
                <div className="form-group">
                    <label>Message</label>
                    <textarea value={formData.message} placeholder="Describe your review..." onChange={handleChange('message')} />
                </div>
            </div>
            
            <button className="submit-btn" type="submit">Submit</button>
        </form>
    );
};
export default ContactTab;