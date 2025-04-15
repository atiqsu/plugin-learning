  import React from 'react';
  import DisplayModeToggle from './DisplayModeToggle';


  const SettingsTab = ({displayMode, setDisplayMode}) => {
    return (
      <div className='settings-tab'>
        <h2>Settings</h2>
        <div className='settings-control'>
          <DisplayModeToggle onChange={setDisplayMode} currentMode={displayMode} />
        </div>
      </div>
    )
  }

  export default SettingsTab