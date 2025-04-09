import React, {useState} from "react";

import ReactDOM from 'react-dom';

import '../scss/main.scss';

import FormComponent from '../components/FormComponent';

const App = () => {
    const [activeTab, setActiveTab] = useState('General');

    const tabs = ['General', 'Advanced', 'Custom'];

    const renderContent = () => {
        switch(activeTab) {
            case 'General': 
                return React.createElement(FormComponent);
            case 'Advanced':
                return React.createElement('p', null, 'This is the advanced tab');
            case 'Custom':
                return React.createElement('p', null, 'This is the custom tab');
            default:
                return null;            
        }
    };

    return React.createElement(
        'div',
        {className: 'plugin-dashboard'},
        React.createElement(
            'div',
            {className: 'tabs'},
            tabs.map((tab) => 
                React.createElement(
                    'button',
                    {
                        key: tab,
                        onClick: () => setActiveTab(tab),
                        className: `tab-button ${activeTab === tab ? 'active' : ''}`,
                    },
                    tab
                )
            )
        ),
        React.createElement('div', {className: 'tab-content'}, renderContent())

    );
};

ReactDOM.render(
    React.createElement(App),
    document.getElementById('react-dashboard')
);

const rootAdmin = document.getElementById('react-dashboard');
const rootFrontend = document.getElementById('react-user-form');

if(rootAdmin) {
    ReactDOM.render(React.createElement(App), rootAdmin);
}

if(rootFrontend){
    ReactDOM.render(React.createElement(FormComponent), rootFrontend);
}