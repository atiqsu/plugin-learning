import React, {act, useState} from 'react'

const Tabs = ({children}) => {

  const [activeTab, setActiveTab] = useState(children[0].props.name);

  const tabCount = children.length;
  const tabWidth = `${100/tabCount}%`;

  return (
    <div className='tab-wrapper'>
        <div className='tab-buttons' style={{display: 'flex', width: '100%'}}>
            {children.map((child) => (
              <button
                key={child.props.name}
                className={child.props.name === activeTab ? 'active' : ''}
                onClick={() => setActiveTab(child.props.name)}
                style={{
                  flex: `0 0 ${tabWidth}`,
                  padding: '12px 0',
                  backgroundColor: child.props.name === activeTab ? '#333' : 'transparent',
                  color: child.props.name === activeTab ? '#fff' : '#00bfff',
                  cursor: 'pointer',
                  fontWeight: '500'
                }}
              >
                {child.props.name}
              </button>
            ))}
        </div>

        <div className='tab-content' style={{padding: '20px'}}>
            {children.map((child) => {
                if(child.props.name !== activeTab) return null;
                return <div key={child.props.name}>{child.props.children}</div>;
            })}
        </div>
    </div>
  );
};

export default Tabs