import React from "react";
import DefaultLayout from "../../../../layout/DefaultLayout";
import LearningPathForm from "../../../../components/Forms/Settings/LearningPathForm";

interface EditProps {
    learningPath: {
        id: number;
        title: string;
        items: Array<{
            id: number;
            item_type: string;
            item_id: number;
            name: string;
            order: number;
            mandatory: boolean;
            main_category: string;
            sub_category: string;
        }>;
    };
    lawGuideCategories: any[];
    bookGuideCategories: any[];
    lawGuides: any;
    bookGuides: any;
    lawGuideLaws: any;
    bookGuideSections: any;
}

const Edit: React.FC<EditProps> = ({
    learningPath,
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
                    <h2 className="text-2xl font-bold text-right text-black dark:text-white">
                        تعديل مسار القراءة
                    </h2>
                </div>

                <LearningPathForm
                    learningPath={learningPath}
                    lawGuideCategories={lawGuideCategories}
                    bookGuideCategories={bookGuideCategories}
                    lawGuides={lawGuides}
                    bookGuides={bookGuides}
                    lawGuideLaws={lawGuideLaws}
                    bookGuideSections={bookGuideSections}
                    isEdit={true}
                />
            </div>
        </DefaultLayout>
    );
};

export default Edit;
