import React, {useEffect, useState} from 'react'

const DisplayModeToggle = ({onChange}) => {
    const [mode, setMode] = useState('light');

    useEffect(() => {
        fetch(`${myPluginData.rest_url}my-plugin/v1/get-mode`)
        .then(res => res.json())
        .then(data => {
            setMode(data);
            onchange(data);
        });
    }, []);

    // const toggleMode = () => {
    //     const newMode = mode === 'light' ? 'dark' : 'light';
    //     fetch(`${myPluginData.rest_url}my-plugin/v1/set-mode`, {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type' : 'application/json',
    //             'X-WP-Nonce' : myPluginData.nonce
    //         },
    //         body: JSON.stringify({mode: newMode})
    //     })
    //     .then(res => res.json())
    //     .then(() => {
    //         setMode(newMode);
    //         onChange(newMode);
    //     });
    // };


    // return (
    //     <div style={{marginBottom: '15px'}}>
    //         <button onClick={toggleMode}>
    //             Switch to {mode === 'light' ? 'Dark' : 'Light'} Mode
    //         </button>
    //     </div>    
    // )
    const handleChange = (event) => {
      const newMode = event.target.value;

      fetch(`${myPluginData.rest_url}my-plugin/v1/set-mode`, {
        method: 'POST',
        headers: {
          'Content-Type' : 'application/json',
          'X-WP-Nonce' : myPluginData.nonce
        },
        body: JSON.stringify({mode: newMode})
      })
      .then(res => res.json())
      .then(() => {
        setMode(newMode);
        onChange(newMode);
      });

    };

    return(
      <div className='mode-toggle'>
        <label htmlFor='display-mode'>Mode</label>
        <select id='display-mode' value={mode} onChange={handleChange}>
          <option value="default">Default</option>
          <option value="light">Light</option>
          <option value="dark">Dark</option>
        </select>
      </div>
    );
}

export default DisplayModeToggle