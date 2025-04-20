import React from "react";
import DefaultLayout from "../../../../layout/DefaultLayout";
import LearningPathForm from "../../../../components/Forms/Settings/LearningPathForm";

interface CreateProps {
    lawGuideCategories: any[];
    bookGuideCategories: any[];
    lawGuides: any;
    bookGuides: any;
    lawGuideLaws: any;
    bookGuideSections: any;
}

const Create: React.FC<CreateProps> = ({
    lawGuideCategories,
    bookGuideCategories,
    lawGuides,
    bookGuides,
    lawGuideLaws,
    bookGuideSections,
}) => {
    return (
        <DefaultLayout>
            <div className="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
                <div className="mb-6">
                    <h2 className="text-2xl font-bold text-black dark:text-white">
                        إضافة مسار قراءة جديد
                    </h2>
                </div>

                <LearningPathForm
                    lawGuideCategories={lawGuideCategories}
                    bookGuideCategories={bookGuideCategories}
                    lawGuides={lawGuides}
                    bookGuides={bookGuides}
                    lawGuideLaws={lawGuideLaws}
                    bookGuideSections={bookGuideSections}
                />
            </div>
        </DefaultLayout>
    );
};

export default Create;
