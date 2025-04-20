import toast from "react-hot-toast";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import ProductsForm from "../../../../components/Forms/Settings/PackageForm";
import DefaultLayout from "../../../../layout/DefaultLayout";
import { router } from "@inertiajs/react";
import axios from "axios";
import React, { useRef, useState } from "react";
import SuccessNotification from "../../../../components/SuccessNotification";
import ErrorNotification from "../../../../components/ErrorNotification";

export default function ({
    item,
    services,
    types,
    advisoryServicesTypes,
    reservationTypes,
    permissions,
    sections,
}) {
    types = types.slice(0, 4);
    types.push({ id: 5, name: "هيئة" });
    console.log(types);
    const [packageName, setPackageName] = useState(item.name);
    const [duration, setDuration] = useState(item.duration);
    const [targetedType, setTargetedType] = useState(item.targetedType);
    const [priceBeforeDiscount, setPriceBeforeDiscount] = useState(
        item.priceBeforeDiscount
    );
    const [priceAfterDiscount, setPriceAfterDiscount] = useState(
        item.priceAfterDiscount
    );
    const [instructions, setInstructions] = useState(item.instructions);
    const [selectedServices, setSelectedServices] = useState(
        item.services.map((service) => ({
            id: service.id,
            number_of_bookings: service.pivot.number_of_bookings,
        }))
    );
    console.log(item);
    const [selectedAdvisoryServicesTypes, setSelectedAdvisoryServicesTypes] =
        useState(
            item.advisory_services.map((advisoryServiceType) => ({
                id: advisoryServiceType.id,
                number_of_bookings:
                    advisoryServiceType.pivot.number_of_bookings,
            }))
        );
    const [selectedReservationTypes, setSelectedReservationTypes] = useState(
        item.reservations.map((reservationType) => ({
            id: reservationType.id,
            number_of_bookings: reservationType.pivot.number_of_bookings,
        }))
    );
    const [packageType, setPackageType] = useState(item.package_type);
    const [numberOfServices, setNumberOfServices] = useState(
        item.number_of_services
    );
    const [numberOfAdvisoryServices, setNumberOfAdvisoryServices] = useState(
        item.number_of_advisory_services
    );
    const [numberOfReservations, setNumberOfReservations] = useState(
        item.number_of_reservations
    );
    const [durationType, setDurationType] = useState(item.duration_type);
    const contentRef = useRef<HTMLDivElement>(null);
    const [selectedLawyerPermissions, setSelectedLawyerPermissions] = useState(
        item.permissions.map((permission) => permission.id.toString())
    );
    const [selectedSections, setSelectedSections] = useState(
        item.sections.map((sec) => sec.id.toString())
    );

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
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    const [errors, setErrors] = useState([]);
    const [progress, setProgress] = useState(0);

    const saveData = async () => {
        try {
            setIsError(false);
            setIsSuccess(false);
            setErrors([]);
            setProgress(0);

            contentRef.current?.scrollTo({ top: 0, behavior: "smooth" });
            const res = await axios.post(
                `/newAdmin/settings/packages/${item.id}`,

                {
                    packageName,
                    duration,
                    targetedType,
                    priceBeforeDiscount,
                    priceAfterDiscount,
                    instructions,
                    selectedServices:
                        packageType == "1" ? selectedServices : [],
                    selectedAdvisoryServicesTypes:
                        packageType == "1" ? selectedAdvisoryServicesTypes : [],
                    selectedReservationTypes:
                        packageType == "1" ? selectedReservationTypes : [],
                    packageType,
                    number_of_services:
                        packageType == "1" ? numberOfServices : 0,
                    number_of_advisory_services:
                        packageType == "1" ? numberOfAdvisoryServices : 0,
                    number_of_reservations:
                        packageType == "1" ? numberOfReservations : 0,
                    durationType,
                    taxes,
                    selectedLawyerPermissions:
                        packageType == "2" ? selectedLawyerPermissions : [],
                    sections: packageType == "2" ? selectedSections : [],
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
                setIsSuccess(true);
                setTimeout(() => {
                    router.get("/newAdmin/settings/packages");
                }, 2000);
            }
        } catch (err) {
            setErrors(err.response.data.errors);
            setIsError(true);
            contentRef.current?.scrollTo({ top: 0, behavior: "smooth" });
        }
    };
    const [taxes, setTaxes] = useState(item.taxes);

    return (
        <DefaultLayout ref={contentRef}>
            <Breadcrumb pageName="تعديل باقة" />
            {isSuccess && <SuccessNotification classNames="my-2" />}
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
