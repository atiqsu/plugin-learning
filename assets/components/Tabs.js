import React, {useState} from 'react'

const Tabs = ({children}) => {
  const [activeTab, setActiveTab] = useState(children[0].props.name);
  return (
    <div className='tab-wrapper'>
        <div className='tab-buttons'>
            {children.map((child) => (
              <button
                key={child.props.name}
                className={child.props.name === activeTab ? 'active' : ''}
                onClick={() => setActiveTab(child.props.name)}
              >
                {child.props.name}
              </button>
            ))}
        </div>
        <div>
            {children.map((child) => {
                if(child.props.name !== activeTab) return null;
                return <div key={child.props.name}>{child.props.children}</div>;
            })}
        </div>
    </div>
  );
};

export default Tabs