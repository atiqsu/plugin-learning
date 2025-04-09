import React, { useState } from "react";
import { createRoot } from "react-dom/client";

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
        { className: 'plugin-dashboard' },
        React.createElement(
            'div',
            { className: 'tabs' },
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
        React.createElement('div', { className: 'tab-content' }, renderContent())
    );
};

// DOM mount points
const rootAdmin = document.getElementById('react-dashboard');
const rootFrontend = document.getElementById('react-user-form');

if (rootAdmin) {
    const root = createRoot(rootAdmin);
    root.render(React.createElement(App));
}

if (rootFrontend) {
    const root = createRoot(rootFrontend);
    root.render(React.createElement(FormComponent));
}
