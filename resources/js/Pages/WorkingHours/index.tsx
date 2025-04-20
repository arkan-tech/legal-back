import axios from "axios";
import { useEffect, useRef, useState } from "react";
import toast from "react-hot-toast";
import DefaultLayout from "../../layout/DefaultLayout";
import React from "react";
import Breadcrumb from "../../components/Breadcrumbs/Breadcrumb";
import MailerForm from "../../components/Forms/MailerForm/MailerForm";
import SelectGroup from "../../components/Forms/SelectGroup/SelectGroup";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faPlus, faSave, faTrash } from "@fortawesome/free-solid-svg-icons";
import { router } from "@inertiajs/react";
import SuccessNotification from "../../components/SuccessNotification";
import ErrorNotification from "../../components/ErrorNotification";
const weekDays = [
    { id: "1", name: "الأحد" },
    { id: "2", name: "الأثنين" },
    { id: "3", name: "الثلثاء" },
    { id: "4", name: "الأربعاء" },
    { id: "5", name: "الخميس" },
    { id: "6", name: "الجمعة" },
    { id: "7", name: "السبت" },
];
function Services({ workingSchedule, setIsSuccess, setIsError }) {
    const [services, setServices] = useState([
        { id: 1, name: "المواعيد" },
        { id: 2, name: "الخدمات" },
        { id: 3, name: "الاستشارات" },
    ]);
    const [availableDays, setAvailableDays] = useState([
        { id: "1", name: "الأحد" },
        { id: "2", name: "الأثنين" },
        { id: "3", name: "الثلثاء" },
        { id: "4", name: "الأربعاء" },
        { id: "5", name: "الخميس" },
        { id: "6", name: "الجمعة" },
        { id: "7", name: "السبت" },
    ]);
    const [selectedService, setSelectedService] = useState<{
        id: number;
        name: string;
    } | null>(null);
    const [currentSchedule, setCurrentSchedule] = useState([]);
    const selectService = (service) => {
        setSelectedService(service);
    };

    useEffect(() => {
        if (selectedService != null) {
            if (workingSchedule.some((w) => w.service == selectedService?.id)) {
                let workingScheduleDays = workingSchedule
                    .find((w) => w.service == selectedService.id)
                    .days.map((item) => item.dayOfWeek);

                setAvailableDays(
                    weekDays.filter(
                        (weekDay) => !workingScheduleDays.includes(weekDay.id)
                    )
                );
                setCurrentSchedule(
                    workingSchedule.find((w) => w.service == selectedService.id)
                        .days
                );
            } else {
                setCurrentSchedule([]);
                setAvailableDays(weekDays);
            }
        } else {
            setAvailableDays(weekDays);
            setCurrentSchedule([]);
        }
    }, [selectedService]);

    return (
        <div className="flex flex-col gap-3 items-center">
            <h2 className="text-4xl text-white">المنتجات</h2>
            <ul className="flex gap-4 text-xl">
                {services.map((service) => (
                    <li
                        className={`${
                            selectedService?.id == service.id &&
                            "dark:text-black dark:bg-white text-white bg-boxdark"
                        } hover:cursor-pointer border rounded-xl p-2`}
                        key={service.id}
                        onClick={() => selectService(service)}
                    >
                        {service.name}
                    </li>
                ))}
            </ul>
            {selectedService && (
                <WorkingHours
                    service={selectedService}
                    currentSchedule={currentSchedule}
                    availableDays={availableDays}
                    setAvailableDays={setAvailableDays}
                    setIsSuccess={setIsSuccess}
                    setIsError={setIsError}
                />
            )}
        </div>
    );
}
function WorkingHours({
    service,
    availableDays,
    setAvailableDays,
    currentSchedule,
    setIsSuccess,
    setIsError,
}) {
    const [days, setDays] = useState<{ id; dayOfWeek; timeSlots }[]>([]);
    useEffect(
        () =>
            setDays(
                currentSchedule.map((day, idx) => ({
                    ...day,
                    id: idx,
                    timeSlots: day.timeSlots.map((slot, idx2) => ({
                        id: idx2,
                        ...slot,
                    })),
                }))
            ),
        [currentSchedule]
    );
    const addDay = () => {
        if (days.length == 7) return;

        setDays([...days, { id: Date.now(), dayOfWeek: "", timeSlots: [] }]);
    };

    const removeDay = (id) => {
        const d = days.find((day) => day.id == id);
        setDays(days.filter((day) => day.id != id));
        if (d && d.dayOfWeek) {
            setAvailableDays((prev) =>
                [...prev, weekDays.find((day) => day.id == d?.dayOfWeek)].sort(
                    (a, b) => a.id - b.id
                )
            );
        }
    };

    const updateDay = (id, updatedDay) => {
        setDays(days.map((day) => (day.id === id ? updatedDay : day)));
        if (availableDays.some((day) => day.id == updatedDay.dayOfWeek)) {
            setAvailableDays((prev) =>
                prev.filter((day) => day.id != updatedDay.dayOfWeek)
            );
        }
    };

    const saveDays = () => {
        let isValid = { status: true, message: "" };
        for (let i = 0; i < days.length; i++) {
            const day = days[i];
            if (day.timeSlots.length > 0) {
                if (
                    day.timeSlots.filter(
                        (timeSlot) => timeSlot.from == "" || timeSlot.to == ""
                    ).length > 0
                )
                    isValid = { status: false, message: "يوجد موعد غير مكتمل" };
            } else {
                isValid = {
                    status: false,
                    message: "يوجد يوم بلا مواعيد",
                };
            }
        }

        if (isValid.status) {
            axios
                .post("/newAdmin/settings/working-hours/create", {
                    service: service.id,
                    workingSchedule: days,
                })
                .then((res) => {
                    setIsSuccess(true);
                });
        } else {
            setIsError(isValid);
        }
    };
    return (
        <div
            style={{ direction: "rtl" }}
            className="flex flex-col gap-2 items-center"
        >
            <h3 className="text-3xl">مواعيد {service.name}</h3>
            <div className="flex gap-2">
                <button
                    onClick={addDay}
                    className="border rounded-xl py-2 px-3 gap-2 flex items-center"
                >
                    <FontAwesomeIcon icon={faPlus} />
                    اضافة يوم
                </button>
                <button
                    onClick={saveDays}
                    className="rounded-xl py-2 px-3 gap-2 flex items-center bg-primary text-white"
                >
                    <FontAwesomeIcon icon={faSave} />
                    حفظ
                </button>
            </div>
            {days.map((day) => (
                <Day
                    key={day?.id}
                    day={day}
                    updateDay={updateDay}
                    removeDay={removeDay}
                    availableDays={availableDays}
                    setAvailableDays={setAvailableDays}
                />
            ))}
        </div>
    );
}

function Day({ day, updateDay, removeDay, availableDays, setAvailableDays }) {
    const [selectedAvailableDay, setSelectedAvailableDay] = useState("");
    const handleChangeDay = (e) => {
        updateDay(day.id, { ...day, dayOfWeek: e.target.value });
    };

    const addTimeSlot = () => {
        const newTimeSlot = { id: Date.now(), from: "", to: "" };
        const updatedTimeSlots = [...day.timeSlots, newTimeSlot];

        updateDay(day.id, { ...day, timeSlots: updatedTimeSlots });
    };

    useEffect(() => {
        if (selectedAvailableDay != "") {
            updateDay(day.id, {
                ...day,
                dayOfWeek: selectedAvailableDay,
            });
        }
    }, [selectedAvailableDay]);
    const removeTimeSlot = (id) => {
        const updatedTimeSlots = day.timeSlots.filter((slot) => slot.id !== id);
        updateDay(day.id, { ...day, timeSlots: updatedTimeSlots });
    };

    return (
        <div className="flex flex-col gap-2 justify-center items-center">
            <div className="flex justify-center items-end gap-4 my-4">
                <div className="flex flex-col w-1/2 gap-2">
                    <label>اليوم</label>
                    {day.dayOfWeek ? (
                        <input
                            type="text"
                            className="w-full rounded border-[1.5px] border-strokedark bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                            value={
                                weekDays.find((d) => d.id == day.dayOfWeek)
                                    ?.name
                            }
                            disabled
                        />
                    ) : (
                        <SelectGroup
                            options={availableDays}
                            selectedOption={selectedAvailableDay}
                            setSelectedOption={setSelectedAvailableDay}
                            title="اليوم"
                        />
                    )}
                </div>
                <div className="flex justify-center gap-2 items-center">
                    {day.dayOfWeek && (
                        <button
                            onClick={addTimeSlot}
                            className="border rounded-xl py-2 px-3 gap-2 flex items-center"
                        >
                            <FontAwesomeIcon icon={faPlus} />
                            اضافة موعد
                        </button>
                    )}

                    <button onClick={() => removeDay(day.id)}>
                        <FontAwesomeIcon icon={faTrash} />
                    </button>
                </div>
            </div>
            {day.timeSlots.map((slot) => {
                return (
                    <div key={slot.id} className="flex gap-2">
                        <div className="flex flex-col gap-2">
                            <label>من</label>
                            <input
                                type="time"
                                value={slot.from}
                                className="w-full rounded border-[1.5px] border-strokedark bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                onChange={(e) => {
                                    updateDay(day.id, {
                                        ...day,
                                        timeSlots: day.timeSlots.map((s) =>
                                            s.id === slot.id
                                                ? {
                                                      ...s,
                                                      from: e.target.value,
                                                  }
                                                : s
                                        ),
                                    });
                                }}
                            />
                        </div>
                        <div className="flex flex-col gap-2">
                            <label>الى</label>

                            <input
                                type="time"
                                className="w-full rounded border-[1.5px] border-strokedark bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                value={slot.to}
                                onChange={(e) => {
                                    updateDay(day.id, {
                                        ...day,
                                        timeSlots: day.timeSlots.map((s) =>
                                            s.id === slot.id
                                                ? { ...s, to: e.target.value }
                                                : s
                                        ),
                                    });
                                }}
                            />
                        </div>
                        <button onClick={() => removeTimeSlot(slot.id)}>
                            <FontAwesomeIcon icon={faTrash} />
                        </button>
                    </div>
                );
            })}
        </div>
    );
}

function WorkingHoursPage({ workingSchedule, workingHours }) {
    const contentRef = useRef<HTMLDivElement>(null);
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState({
        state: false,
        message: "",
    });
    return (
        <DefaultLayout>
            <div ref={contentRef}>
                <Breadcrumb pageName="مواعيد العمل ليمتاز" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError.state && (
                    <ErrorNotification
                        message={isError.message}
                        classNames="my-2"
                    />
                )}
                <Services
                    workingSchedule={workingSchedule}
                    setIsSuccess={setIsSuccess}
                    setIsError={setIsError}
                />
            </div>
        </DefaultLayout>
    );
}
export default WorkingHoursPage;
