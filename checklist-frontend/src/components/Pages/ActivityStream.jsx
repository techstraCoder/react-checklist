import React, { useState } from 'react';
import '../css/ActivityStream.css';

const ActivityStream = ({ activitymessages, activityCount, loadmore }) => {
    const [displayedActivitiesCount, setDisplayedActivitiesCount] = useState(3);
    const [showAccordion, setShowAccordion] = useState(false);

    const handleLoadMore = () => {
        setDisplayedActivitiesCount(displayedActivitiesCount + 3);
    };

    const toggleAccordion = () => {
        setShowAccordion(!showAccordion);
    };

    const hasMoreActivitiesToShow = activitymessages?.length > displayedActivitiesCount;

    return (
        <div className="outer-container">
            <div className="accordion" id="accordionExample">
                <div className="accordion-item">
                    <button
                        className={`accordion-button ${showAccordion ? '' : 'collapsed'}`}
                        type="button"
                        onClick={toggleAccordion}
                    >
                        Activity Stream
                    </button>
                    <div
                        id="collapseOne"
                        className={`accordion-collapse collapse ${showAccordion ? 'show' : ''}`}
                        aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample"
                    >
                        <div className="accordion-body">
                            {activitymessages?.slice(0, displayedActivitiesCount).map((item, index) => (
                                <div key={index} className="activitymessages" data-index={index}>
                                    <p>{item.activity_message}</p>
                                    <p>{item.date_updated}</p>
                                </div>
                            ))}

                            {hasMoreActivitiesToShow && (

                                <button
                                    className="loadMore"
                                    onClick={handleLoadMore}
                                >
                                    Load More activities...
                                </button>

                            )}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default ActivityStream;
