import React, { useState } from "react";
import { createRoot } from "react-dom/client";
import '../scss/main.scss';
import Tabs from "../components/Tabs";
import Tab from "../components/Tab";
import HomeTab from "../components/HomeTab";
import ProfileTab from "../components/ProfileTab";
import ContactTab from "../components/ContactTab";
import SettingsTab from "../components/SettingsTab";
import DisplayModeToggle from "../components/DisplayModeToggle";


const App = () => {
    
    const [displayMode, setDisplayMode] = useState('light');

    return (
        <div className={`plugin-dashboard ${displayMode}-mode`}>
            {/* <DisplayModeToggle onChange={setDisplayMode} /> */}
            <Tabs>
                <Tab name="Home">
                    <HomeTab />
                </Tab>
                <Tab name="Profile">
                    <ProfileTab />
                </Tab>
                <Tab name="Contact">
                    <ContactTab />
                </Tab>
                <Tab name="Settings">
                    <SettingsTab displayMode={displayMode} setDisplayMode={setDisplayMode} />
                </Tab>
            </Tabs>
        </div>
    
   );

    // const [activeTab, setActiveTab] = useState('General');

    // const tabs = ['General', 'Advanced', 'Custom'];

    // const renderContent = () => {
    //     switch(activeTab) {
    //         case 'General': 
    //             return React.createElement(ContactTab);
    //         case 'Advanced':
    //             return React.createElement('p', null, 'This is the advanced tab');
    //         case 'Custom':
    //             return React.createElement('p', null, 'This is the custom tab');
    //         default:
    //             return null;            
    //     }
    // };

    // return React.createElement(
    //     'div',
    //     { className: 'plugin-dashboard' },
    //     React.createElement(
    //         'div',
    //         { className: 'tabs' },
    //         tabs.map((tab) =>
    //             React.createElement(
    //                 'button',
    //                 {
    //                     key: tab,
    //                     onClick: () => setActiveTab(tab),
    //                     className: `tab-button ${activeTab === tab ? 'active' : ''}`,
    //                 },
    //                 tab
    //             )
    //         )
    //     ),
    //     React.createElement('div', { className: 'tab-content' }, renderContent())
    // );
};

// DOM mount points
const rootAdmin = document.getElementById('react-dashboard');
const rootFrontend = document.getElementById('react-user-form');

if (rootAdmin) {
    const root = createRoot(rootAdmin);
    root.render(<App />);
}

if (rootFrontend) {
    const root = createRoot(rootFrontend);
    root.render(<ContactTab />);
}