import toast from "react-hot-toast";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import ProductsForm from "../../../../components/Forms/Settings/PackageForm";
import DefaultLayout from "../../../../layout/DefaultLayout";
import { router } from "@inertiajs/react";
import axios from "axios";
import React, { useRef, useState } from "react";
import ErrorNotification from "../../../../components/ErrorNotification";

export default function ({
    services,
    types,
    advisoryServicesTypes,
    reservationTypes,
    permissions,
    sections,
}) {
    types = types.slice(0, 4);
    types.push({ id: 5, name: "هيئة" });
    const [packageName, setPackageName] = useState("");
    const [progress, setProgress] = useState(0);
    const [duration, setDuration] = useState("");
    const [targetedType, setTargetedType] = useState("");
    const [priceBeforeDiscount, setPriceBeforeDiscount] = useState();
    const [priceAfterDiscount, setPriceAfterDiscount] = useState();
    const [instructions, setInstructions] = useState("");
    const [selectedServices, setSelectedServices] = useState([]);
    const [selectedAdvisoryServicesTypes, setSelectedAdvisoryServicesTypes] =
        useState([]);
    const [selectedReservationTypes, setSelectedReservationTypes] = useState(
        []
    );
    const [durationType, setDurationType] = useState("");
    const [packageType, setPackageType] = useState("");
    const [numberOfServices, setNumberOfServices] = useState(0);
    const [numberOfAdvisoryServices, setNumberOfAdvisoryServices] = useState(0);
    const [numberOfReservations, setNumberOfReservations] = useState(0);
    const [selectedLawyerPermissions, setSelectedLawyerPermissions] = useState(
        []
    );
    const [selectedSections, setSelectedSections] = useState([]);
    services = services.map((service) => ({
        id: service.id,
        title: service.title,
        prices: service.ymtaz_levels_prices.map((level) => ({
            price: level.price,
            title: level.level.title,
        })),
    }));
    advisoryServicesTypes = advisoryServicesTypes.map(
        (advisoryServiceType) => ({
            id: advisoryServiceType.id,
            title: advisoryServiceType.title,
            prices: advisoryServiceType.advisory_services_prices.map(
                (level) => ({
                    price: level.price,
                    title: level.importance.title,
                })
            ),
        })
    );
    console.log(reservationTypes);
    reservationTypes = reservationTypes.map((reservationType) => {
        return {
            id: reservationType.id,
            title: reservationType.name,
            prices: reservationType.types_importance.map((level) => ({
                price: level.price,
                title: level.reservation_importance.name,
            })),
        };
    });
    const [errors, setErrors] = useState([]);
    const [isError, setIsError] = useState(false);
    const [taxes, setTaxes] = useState(null);
    const contentRef = useRef<HTMLDivElement>(null);
    const saveData = async () => {
        try {
            contentRef.current?.scrollTo({ top: 0, behavior: "smooth" });
            setErrors([]);
            setIsError(false);

            setProgress(0);
            const res = await axios.post(
                "/newAdmin/settings/packages/store",
                {
                    packageName,
                    duration,
                    targetedType,
                    priceBeforeDiscount,
                    priceAfterDiscount,
                    instructions,
                    selectedServices: selectedServices,
                    selectedAdvisoryServicesTypes:
                        selectedAdvisoryServicesTypes,
                    selectedReservationTypes: selectedReservationTypes,
                    packageType,
                    number_of_services: numberOfServices,
                    number_of_advisory_services: numberOfAdvisoryServices,
                    number_of_reservations: numberOfReservations,
                    durationType,
                    taxes,
                    selectedLawyerPermissions,
                    sections: selectedSections,
                },
                {
                    onUploadProgress: (event) => {
                        const percent = Math.floor(
                            (event.loaded * 100) / event.total!
                        );
                        setProgress(percent);
                    },
                }
            );
            if (res.status == 200) {
                toast.success("تم انشاء الملف بنجاح");
                router.get(`/newAdmin/settings/packages`);
            }
        } catch (err) {
            console.log(err.response.data.errors);
            setIsError(true);

            setErrors(err.response.data.errors);
        }
    };
    return (
        <DefaultLayout ref={contentRef}>
            <Breadcrumb pageName="اضافة باقة" />
            {isError && <ErrorNotification classNames="my-2" />}

            <ProductsForm
                saveData={saveData}
                packageName={packageName}
                setPackageName={setPackageName}
                duration={duration}
                setDuration={setDuration}
                targetedType={targetedType}
                setTargetedType={setTargetedType}
                priceBeforeDiscount={priceBeforeDiscount}
                setPriceBeforeDiscount={setPriceBeforeDiscount}
                priceAfterDiscount={priceAfterDiscount}
                setPriceAfterDiscount={setPriceAfterDiscount}
                instructions={instructions}
                setInstructions={setInstructions}
                selectedServices={selectedServices}
                setSelectedServices={setSelectedServices}
                types={types}
                services={services}
                advisoryServicesTypes={advisoryServicesTypes}
                errors={errors}
                selectedAdvisoryServicesTypes={selectedAdvisoryServicesTypes}
                setSelectedAdvisoryServicesTypes={
                    setSelectedAdvisoryServicesTypes
                }
                reservationTypes={reservationTypes}
                selectedReservationTypes={selectedReservationTypes}
                setSelectedReservationTypes={setSelectedReservationTypes}
                packageType={packageType}
                setPackageType={setPackageType}
                numberOfServices={numberOfServices}
                setNumberOfServices={setNumberOfServices}
                numberOfAdvisoryServices={numberOfAdvisoryServices}
                setNumberOfAdvisoryServices={setNumberOfAdvisoryServices}
                numberOfReservations={numberOfReservations}
                setNumberOfReservations={setNumberOfReservations}
                progress={progress}
                durationType={durationType}
                setDurationType={setDurationType}
                taxes={taxes}
                setTaxes={setTaxes}
                permissions={permissions}
                selectedLawyerPermissions={selectedLawyerPermissions}
                setSelectedLawyerPermissions={setSelectedLawyerPermissions}
                sections={sections}
                selectedSections={selectedSections}
                setSelectedSections={setSelectedSections}
            />
        </DefaultLayout>
    );
}
